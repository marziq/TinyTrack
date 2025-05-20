<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Baby;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $totalUsers = User::count(); // Fetch total user count
        $totalBabies = Baby::count(); // Fetch total baby count
        return view('admin.dashboard-admin', compact('totalUsers', 'totalBabies'));
    }

    public function usersAdmin()
    {
        $users = \App\Models\User::all();
        return view('admin.users-admin', compact('users'));
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
    public function update(Request $request, \App\Models\User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'gender' => 'nullable|in:male,female,other',
            'mobile_number' => 'nullable|string|max:20',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->gender = $request->gender;
        $user->mobile_number = $request->mobile_number;
        $user->save();

        return redirect()->route('users-admin')->with('success', 'User updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $user = \App\Models\User::findOrFail($id);
        $user->delete();
        return redirect()->route('users-admin')->with('success', 'User deleted successfully.');
    }
}
