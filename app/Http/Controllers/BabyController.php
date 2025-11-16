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
        $hasBabies = $babies->isNotEmpty(); // Check if the user has any babies

        // Check the route or request parameter to decide which view to return
        if (request()->routeIs('appointment')) {
            return view('user.appointment', compact('babies', 'hasBabies'));
        }

        // Default to the 'mybaby' view
        return view('user.mybaby', compact('babies', 'hasBabies'));
    }
    public function showMyBaby()
    {
        $babies = Auth::user()->babies;
        $hasBabies = $babies->isNotEmpty();

        return view('user.mybaby', compact('babies', 'hasBabies'));
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
        // basic validation for textual fields
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'birth_date' => 'required|date',
            'gender' => 'required|string|in:male,female',
            'ethnicity' => 'required|string',
            'premature' => 'nullable|boolean',
            // 'baby_photo' will be handled below (either uploaded file or preset filename)
        ]);

        // Handle baby photo: either an uploaded file or a preset filename sent from the gallery
        $presetFilenames = ['baby1.png','baby2.png','baby3.png','baby4.png','baby5.png','baby6.png'];

        if ($request->hasFile('baby_photo')) {
            $validated['baby_photo_path'] = $request->file('baby_photo')->store('baby-photos', 'public');
        } elseif ($request->filled('baby_photo')) {
            $inputVal = $request->input('baby_photo');
            // if the client sent a preset filename (e.g. baby1.png)
            if (in_array($inputVal, $presetFilenames)) {
                // ensure preset exists in public/img/baby-options and copy to storage/public/baby-photos
                $source = public_path('img/baby-options/' . $inputVal);
                $targetRelative = 'baby-photos/' . $inputVal;
                $target = storage_path('app/public/' . $targetRelative);
                if (file_exists($source) && !file_exists($target)) {
                    // create directory if not exists
                    @mkdir(dirname($target), 0755, true);
                    copy($source, $target);
                }
                // if copied or already exists, store relative path
                if (file_exists($target)) {
                    $validated['baby_photo_path'] = $targetRelative;
                }
            } else {
                // if the client provided a storage path already, accept it (basic sanitation)
                if (str_contains($inputVal, 'baby-photos/') || str_contains($inputVal, 'storage/')) {
                    // normalize
                    $validated['baby_photo_path'] = str_replace('storage/', '', $inputVal);
                }
            }
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
        // basic validation for textual fields
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'birth_date' => 'required|date',
            'gender' => 'required|string|in:male,female',
            'ethnicity' => 'required|string',
            'premature' => 'nullable|boolean',
            // 'baby_photo' handled below
        ]);

        $presetFilenames = ['baby1.png','baby2.png','baby3.png','baby4.png','baby5.png','baby6.png'];

        // Handle file upload if present
        if ($request->hasFile('baby_photo')) {
            // Delete old photo if exists
            if ($baby->baby_photo_path) {
                Storage::disk('public')->delete($baby->baby_photo_path);
            }
            $validated['baby_photo_path'] = $request->file('baby_photo')->store('baby-photos', 'public');
        } elseif ($request->filled('baby_photo')) {
            $inputVal = $request->input('baby_photo');
            if (in_array($inputVal, $presetFilenames)) {
                $source = public_path('img/baby-options/' . $inputVal);
                $targetRelative = 'baby-photos/' . $inputVal;
                $target = storage_path('app/public/' . $targetRelative);
                if (file_exists($source) && !file_exists($target)) {
                    @mkdir(dirname($target), 0755, true);
                    copy($source, $target);
                }
                if (file_exists($target)) {
                    // delete old custom photo if it was stored under baby-photos and is different
                    if ($baby->baby_photo_path && $baby->baby_photo_path !== $targetRelative) {
                        Storage::disk('public')->delete($baby->baby_photo_path);
                    }
                    $validated['baby_photo_path'] = $targetRelative;
                }
            } else {
                if (str_contains($inputVal, 'baby-photos/') || str_contains($inputVal, 'storage/')) {
                    $validated['baby_photo_path'] = str_replace('storage/', '', $inputVal);
                }
            }
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
