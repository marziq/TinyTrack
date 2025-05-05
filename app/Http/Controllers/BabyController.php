<?php

namespace App\Http\Controllers;

use App\Models\Baby;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;


class BabyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
{
    $babies = Auth::user()->babies; // Fetch babies for the logged-in user

    // Check the route or request parameter to decide which view to return
    if (request()->routeIs('appointment')) {
        return view('user.appointment', compact('babies'));
    }

    // Default to the 'mybaby' view
    return view('user.mybaby', compact('babies'));
}
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('babies.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
    try {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'birth_date' => 'required|date',
            'gender' => 'required|string|in:male,female',
            'ethnicity' => 'required|string',
            'premature' => 'nullable|boolean',
            'baby_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        // Handle file upload
        if ($request->hasFile('baby_photo')) {
            $validated['baby_photo_path'] = $request->file('baby_photo')->store('baby-photos', 'public');
        }

        // Create baby record
        $baby = new Baby($validated);
        $baby->user_id = Auth::id();
        $baby->save();

        return response()->json([
            'success' => true,
            'message' => 'Baby added successfully!',
            'baby' => $baby
        ]);

    } catch (\Illuminate\Validation\ValidationException $e) {
        return response()->json([
            'success' => false,
            'message' => 'Validation error',
            'errors' => $e->errors()
        ], 422);

    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Server error: ' . $e->getMessage()
        ], 500);
    }
    }

    /**
     * Display the specified resource.
     */
    public function show(Baby $baby)
    {
        return view('babies.show', compact('baby'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Baby $baby)
    {
        return response()->json($baby);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Baby $baby)
{
    try {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'birth_date' => 'required|date',
            'gender' => 'required|string|in:male,female',
            'ethnicity' => 'required|string',
            'premature' => 'nullable|boolean',
            'baby_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        // Handle file upload if present
        if ($request->hasFile('baby_photo')) {
            // Delete old photo if exists
            if ($baby->baby_photo_path) {
                Storage::disk('public')->delete($baby->baby_photo_path);
            }
            $validated['baby_photo_path'] = $request->file('baby_photo')->store('baby-photos', 'public');
        }

        $baby->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Baby updated successfully!',
            'baby' => $baby
        ]);

    } catch (\Illuminate\Validation\ValidationException $e) {
        return response()->json([
            'success' => false,
            'message' => 'Validation error',
            'errors' => $e->errors()
        ], 422);

    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Server error: ' . $e->getMessage()
        ], 500);
    }
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Baby $baby)
    {
        // Delete photo if exists
        if ($baby->baby_photo_path) {
            Storage::disk('public')->delete($baby->baby_photo_path);
        }

        $baby->delete();

        return response()->json(['success' => true]);
    }



}
