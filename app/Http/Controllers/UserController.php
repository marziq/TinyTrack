<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();
        $favorites = $user ? $user->favoriteTips()->latest()->get() : collect();
        return view('user.myaccount', compact('favorites'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
    public function update(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'gender' => ['required', 'string', 'in:Male,Female,Other'],
            'mobile_number' => ['required', 'string', 'max:20'],
            'profile_photo' => ['nullable', 'image', 'max:1024'],
        ]);

        if ($request->hasFile('profile_photo')) {
            $path = $request->file('profile_photo')->store('profile-photos', 'public');
            $user->profile_photo_path = $path;
        }

        $user->forceFill([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'gender' => $validated['gender'],
            'mobile_number' => $validated['mobile_number'],
        ])->save();

        return back()->with('status', 'Profile updated successfully!');
    }

    public function getBabiesCount()
    {
        $user = Auth::user();
        $boys = $user->babies()->where('gender', 'Male')->count();
        $girls = $user->babies()->where('gender', 'Female')->count();

        return [
            'boys' => $boys,
            'girls' => $girls,
            'total' => $boys + $girls
        ];
    }

    /**
     * Remove the authenticated user's account from storage.
     */
    public function destroy(Request $request)
    {
        $user = Auth::user();

        // Require current password for safety
        $request->validate([
            'password' => ['required', 'string'],
        ]);

        if (! Hash::check($request->input('password'), $user->password)) {
            return back()->withErrors(['password' => 'The provided password does not match our records.']);
        }

        // Perform deletion. If there are related records with foreign keys, cascade or handle accordingly.
        Auth::logout();
        $user->delete();

        // Invalidate the session
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('mainpage')->with('status', 'Your account has been deleted.');
    }
}
