<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Growth;
use App\Models\Baby;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class GrowthController extends Controller
{
    public function index()
    {
        $growths = Growth::all();

        foreach ($growths as $record) {
            $baby = Baby::find($record->baby_id);

            $summary = $this->getGrowthSummary(
                $baby->gender,
                $record->growthMonth,
                $record->height,
                $record->weight
            );

            $record->height_status = $summary['height_status'];
            $record->weight_status = $summary['weight_status'];
        }
        $babies = Baby::where('user_id', Auth::id())->get();
        return view('user.growth', compact('growths', 'babies'));
    }

    public function create()
    {
        // Get all babies belonging to the logged-in user
        $babies = Baby::where('user_id', Auth::id())->get();

        return view('user.growth', compact('babies'));
    }
    public function store(Request $request)
    {
        // Validate the incoming request
        $validated = $request->validate([
            'baby_id' => 'required|exists:babies,id',
            'growthMonth' => 'required|numeric|min:0',
            'height' => 'nullable|numeric|min:0',
            'weight' => 'nullable|numeric|min:0',
            'head_circumference' => 'nullable|numeric|min:0',
        ]);

        // Store the data in the database
        Growth::create($validated);

        // Redirect back with a success message
        return redirect()->back()->with('success', 'Growth data saved successfully!');
    }
    public function getGrowthData($babyId)
    {
        $growths = Growth::where('baby_id', $babyId)
            ->orderBy('growthMonth', 'asc')
            ->get();

        foreach ($growths as $record) {
            $baby = Baby::find($record->baby_id);

            $summary = $this->getGrowthSummary(
                $baby->gender,
                $record->growthMonth,
                $record->height,
                $record->weight
            );

            $record->height_status = $summary['height_status'];
            $record->weight_status = $summary['weight_status'];
        }

        return response()->json($growths);
    }

    // ===============================
    // Growth Service Logic (inline)
    // ===============================

    private function loadJson($path)
    {
        $fullPath = storage_path('app/' . $path);
        if (!file_exists($fullPath)) {
            \Log::error("JSON file not found: $fullPath");
            return [];
        }
        $json = file_get_contents($fullPath);
        $data = json_decode($json, true);
        if ($data === null) {
            \Log::error("Failed to decode JSON: $fullPath. Error: " . json_last_error_msg());
            return [];
        }
        return $data;
    }

    private function getGrowthSummary($gender, $month, $height = null, $weight = null)
    {
        $gender = strtolower($gender);

        $lfa = $this->loadJson("who/lfa_{$gender}.json");
        $wfa = $this->loadJson("who/wfa_{$gender}.json");
        \Log::info('Loaded LFA:', $lfa);
        // Find the correct month entry in LFA
        $lfa_row = collect($lfa)->firstWhere('Month', (int)$month);
        $wfa_row = collect($wfa)->firstWhere('Month', (int)$month);

        //Log data for make sure it's loading correctly
        \Log::info("Month: $month, Gender: $gender, LFA found: " . json_encode($lfa_row) . ", WFA found: " . json_encode($wfa_row));

        $height_status = null;
        $weight_status = null;

        if ($height !== null && $lfa_row) {
            $L = $lfa_row['L'];
            $M = $lfa_row['M'];
            $S = $lfa_row['S'];

            $z = $this->calculateZScore($height, $L, $M, $S);
            $height_status = $this->getStatusFromZScore($z);
        }

        if ($weight !== null && $wfa_row) {
            $L = $wfa_row['L'];
            $M = $wfa_row['M'];
            $S = $wfa_row['S'];

            $z = $this->calculateZScore($weight, $L, $M, $S);
            $weight_status = $this->getStatusFromZScore($z);
        }

        return [
            'height_status' => $height_status,
            'weight_status' => $weight_status,
        ];
    }

    // LMS Z-score calculation
    private function calculateZScore($value, $L, $M, $S)
    {
        if ($L == 0) {
            return log($value / $M) / $S;
        } else {
            return (pow($value / $M, $L) - 1) / ($L * $S);
        }
    }

    // Convert Z-score to status
    private function getStatusFromZScore($z)
    {
        if ($z < -3) {
            return 'Severely Low';
        } elseif ($z < -2) {
            return 'Low';
        } elseif ($z <= 2) {
            return 'Normal';
        } elseif ($z <= 3) {
            return 'High';
        } else {
            return 'Very High';
        }
    }
}

