<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Baby;
use App\Models\Vaccination;
use App\Models\Milestone;
use App\Models\Appointment;
use Carbon\Carbon;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Basic counts
        $totalUsers = User::count(); // Fetch total user count
        $totalBabies = Baby::count(); // Fetch total baby count

        // Vaccination counts (administered_at is not null = completed, null = pending)
        $vaccineCompleted = Vaccination::whereNotNull('administered_at')->count();
        $vaccinePending = Vaccination::whereNull('administered_at')->count();

        // Milestone counts
        $milestonesCompleted = Milestone::where('achievedDate', '!=', null)->count();
        $milestonesPending = Milestone::where('achievedDate', null)->count();

        // Babies added per month (current year)
        $year = now()->year;
        $babiesPerMonth = [];
        for ($month = 1; $month <= 12; $month++) {
            $count = Baby::whereYear('created_at', $year)
                ->whereMonth('created_at', $month)
                ->count();
            $babiesPerMonth[] = (int)$count;
        }

        // Gender distribution
        $maleCount = (int)User::where('gender', 'male')->count();
        $femaleCount = (int)User::where('gender', 'female')->count();
        $genderDistribution = [$maleCount, $femaleCount];

        // Appointment progression by purpose/type
        $totalGeneral = Appointment::where('purpose', 'general')->count() ?: 0;
        $completedGeneral = Appointment::where('purpose', 'general')->where('status', 'completed')->count() ?: 0;

        $totalCheckup = Appointment::where('purpose', 'checkup')->count() ?: 0;
        $completedCheckup = Appointment::where('purpose', 'checkup')->where('status', 'completed')->count() ?: 0;

        $totalVaccination = Appointment::where('purpose', 'vaccination')->count() ?: 0;
        $completedVaccination = Appointment::where('purpose', 'vaccination')->where('status', 'completed')->count() ?: 0;

        $totalOthers = Appointment::whereNotIn('purpose', ['general', 'checkup', 'vaccination'])->count() ?: 0;
        $completedOthers = Appointment::whereNotIn('purpose', ['general', 'checkup', 'vaccination'])->where('status', 'completed')->count() ?: 0;

        $appointmentProgress = [
            'general' => $totalGeneral > 0 ? (int)($completedGeneral * 100 / $totalGeneral) : 0,
            'checkup' => $totalCheckup > 0 ? (int)($completedCheckup * 100 / $totalCheckup) : 0,
            'vaccination' => $totalVaccination > 0 ? (int)($completedVaccination * 100 / $totalVaccination) : 0,
            'others' => $totalOthers > 0 ? (int)($completedOthers * 100 / $totalOthers) : 0,
        ];

        // Notifications
        $unreadCount = 0;
        $userNotifications = [];

        return view('admin.dashboard-admin', compact(
            'totalUsers',
            'totalBabies',
            'vaccineCompleted',
            'vaccinePending',
            'milestonesCompleted',
            'milestonesPending',
            'babiesPerMonth',
            'genderDistribution',
            'appointmentProgress',
            'unreadCount',
            'userNotifications'
        ));
    }

    public function usersAdmin()
    {
        $users = \App\Models\User::all();
        return view('admin.users-admin', compact('users'));
    }

    public function settings()
    {
        $user = auth()->user();
        $unreadCount = $user->notifications()->where('status', 'unread')->count();
        $userNotifications = $user->notifications()->orderBy('created_at', 'desc')->get();

        return view('admin.settings', compact('user', 'unreadCount', 'userNotifications'));
    }

    public function updateSettings(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'gender' => 'nullable|in:male,female,other',
            'mobile_number' => 'nullable|string|max:20',
            'website' => 'nullable|string|max:255',
            'github' => 'nullable|string|max:255',
            'twitter' => 'nullable|string|max:255',
            'instagram' => 'nullable|string|max:255',
            'facebook' => 'nullable|string|max:255',
        ]);

        $user->update($request->only([
            'name',
            'email',
            'gender',
            'mobile_number',
            'website',
            'github',
            'twitter',
            'instagram',
            'facebook',
        ]));

        return redirect()->route('adminsettings')->with('success', 'Settings updated successfully!');
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

    /**
     * Display the admin calendar page
     */
    public function calendar()
    {
        $users = User::all();
        $unreadCount = 0;
        $userNotifications = [];

        return view('admin.calendar', compact('users', 'unreadCount', 'userNotifications'));
    }

    /**
     * Fetch appointments for a specific user (for calendar)
     */
    public function getAppointments(Request $request)
    {
        $appointments = Appointment::with('baby')
            ->select('appointmentID', 'appointmentDate', 'appointmentTime', 'purpose', 'status')
            ->get()
            ->map(function ($appointment) {
                $statusColor = match($appointment->status) {
                    'Done' => '#4CAF50',
                    'cancelled' => '#f44336',
                    'Waiting' => '#FF9800',
                    default => '#2196F3'
                };

                $purposeClass = match($appointment->purpose) {
                    'checkup' => 'fc-event-checkup',
                    'vaccination' => 'fc-event-vaccination',
                    'consultation' => 'fc-event-consultation',
                    default => 'fc-event-general'
                };

                return [
                    'id' => $appointment->appointmentID,
                    'title' => ucfirst($appointment->purpose),
                    'start' => $appointment->appointmentDate . 'T' . $appointment->appointmentTime,
                    'backgroundColor' => $statusColor,
                    'borderColor' => $statusColor,
                    'extendedProps' => [
                        'status' => $appointment->status,
                        'purpose' => $appointment->purpose,
                        'baby' => $appointment->baby?->name
                    ]
                ];
            });

        return response()->json($appointments);
    }

}
