<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Growth;
use App\Models\Baby;

class GrowthController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Retrieve all growth records
        $growths = Growth::all();

        // Return a view with the data
        return view('user.growth', compact('growths'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Fetch babies for the logged-in user
        $babies = Baby::where('user_id', auth()->user()->id)->get();

        // Return the view with the babies
        return view('user.growth', compact('babies'));
    }

    /**
     * Store a newly created resource in storage.
     */
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

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
    public function getGrowthData(Request $request, $babyId)
    {
        // Ensure the baby belongs to the authenticated user
        $baby = Baby::where('id', $babyId)
        ->where('user_id', auth()->id())
        ->first();

        if (!$baby) {
        return response()->json(['error' => 'Baby not found or unauthorized access'], 403);
        }

        // Fetch growth data for the baby
        $growthData = Growth::where('baby_id', $babyId)
                    ->orderBy('growthMonth', 'asc') // Use growthMonth for ordering
                    ->get(['growthMonth', 'height', 'weight']);

        // Return the data as JSON
        return response()->json($growthData);
    }
}
