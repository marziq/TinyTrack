<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vaccination;
use App\Models\Baby;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class VaccinationController extends Controller
{
    /**
     * Return vaccinations for a baby. If none exist, create a default schedule based on birth_date.
     */
    public function getVaccinationsByBaby($babyId)
    {
        $baby = Baby::findOrFail($babyId);

        // Basic authorization: ensure the baby belongs to current user
        if (Auth::check() && $baby->user_id !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $vaccinations = Vaccination::where('baby_id', $baby->id)->orderBy('scheduled_date')->get();

        if ($vaccinations->isEmpty()) {
            // default schedule (months offsets)
            $default = [
                ['months' => 0, 'name' => 'BCG'],
                ['months' => 0, 'name' => 'Hepatitis B'],
                ['months' => 2, 'name' => 'DTaP Dose 1'],
                ['months' => 3, 'name' => 'DTaP Dose 2'],
                ['months' => 4, 'name' => 'Pneumokokal Dose 1'],
                ['months' => 5, 'name' => 'DTaP Dose 3'],
                ['months' => 6, 'name' => 'Pneumokokal Dose 2'],
                ['months' => 6, 'name' => 'Measles (Sabah)'],
                ['months' => 9, 'name' => 'JE Dose 1 (Sarawak)'],
                ['months' => 9, 'name' => 'MMR Dose 1'],
                ['months' => 12, 'name' => 'MMR Dose 2'],
                ['months' => 15, 'name' => 'Pneumokokal (Booster)'],
                ['months' => 18, 'name' => 'DTaP (Booster)'],
                ['months' => 21, 'name' => 'JE Booster (Sarawak)'],
            ];

            $birth = null;
            try {
                $birth = Carbon::parse($baby->birth_date);
            } catch (\Exception $e) {
                $birth = Carbon::now();
            }

            $created = [];
            foreach ($default as $item) {
                $scheduled = (clone $birth)->addMonths($item['months'])->startOfDay();
                $v = Vaccination::create([
                    'baby_id' => $baby->id,
                    'vaccine_name' => $item['name'],
                    'scheduled_date' => $scheduled->toDateString(),
                    'status' => 'pending'
                ]);
                $created[] = $v;
            }

            return response()->json(collect($created));
        }

        return response()->json($vaccinations);
    }

    /**
     * Toggle vaccination status (administered <-> pending)
     */
    public function toggle(Request $request, $id)
    {
        $vaccination = Vaccination::findOrFail($id);

        $baby = $vaccination->baby;
        if (Auth::check() && $baby->user_id !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        if ($vaccination->status === 'pending') {
            $vaccination->status = 'administered';
            $vaccination->administered_at = Carbon::now();
        } else {
            $vaccination->status = 'pending';
            $vaccination->administered_at = null;
        }

        $vaccination->save();

        return response()->json($vaccination);
    }

    /**
     * Update administered date for a vaccination.
     */
    public function update(Request $request, $id)
    {
        $vaccination = Vaccination::findOrFail($id);

        $baby = $vaccination->baby;
        if (Auth::check() && $baby->user_id !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $data = $request->only(['administered_at']);

        // Allow empty/null to clear the administered date
        if (empty($data['administered_at'])) {
            $vaccination->administered_at = null;
            $vaccination->status = 'pending';
        } else {
            // Expecting YYYY-MM-DD or ISO date
            try {
                $dt = Carbon::parse($data['administered_at']);
                $vaccination->administered_at = $dt->toDateString();
                $vaccination->status = 'administered';
            } catch (\Exception $e) {
                return response()->json(['error' => 'Invalid date format'], 422);
            }
        }

        $vaccination->save();

        return response()->json($vaccination);
    }
}
