<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appointment;
use Carbon\Carbon;

class AppointmentController extends Controller
{
    public function getAppointmentsByBaby($babyId)
    {
        $appointments = Appointment::where('baby_id', $babyId)
            ->join('babies', 'appointments.baby_id', '=', 'babies.id')
            ->select('appointments.*', 'babies.name as babyName')
            ->get();

        return response()->json($appointments);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
        \Log::info('Appointment store request received', $request->all());

        $request->validate([
            'baby_id' => 'required|exists:babies,id',
            'appointmentDate' => 'required|date',
            'appointmentTime' => 'required',
            'purpose' => 'required'
        ]);

        try {
            // Parse and format the date correctly
            $appointmentDate = \Carbon\Carbon::parse($request->appointmentDate)->format('Y-m-d');
            // Parse and format the time
            $appointmentTime = \Carbon\Carbon::parse($request->appointmentTime)->format('H:i:s');

            // Calculate status based on appointment date
            $status = \Carbon\Carbon::parse($appointmentDate)->isFuture() ? 'Waiting' : 'Done';

            $appointment = Appointment::create([
                'baby_id' => $request->baby_id,
                'appointmentDate' => $appointmentDate,
                'appointmentTime' => $appointmentTime,
                'purpose' => $request->purpose,
                'status' => $status
            ]);

            \Log::info('Appointment created successfully', ['appointment' => $appointment]);
            return response()->json($appointment);
        } catch (\Exception $e) {
            \Log::error('Error creating appointment: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to create appointment'], 500);
        }
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
}
