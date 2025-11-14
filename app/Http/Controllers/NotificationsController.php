<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\Request;

class NotificationsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $notifications = Notification::with('user')->orderByDesc('dateSent')->get();

        // Only get unread notifications for the bell
        $userNotifications = Notification::where('user_id', auth()->id())
            ->where('status', 'unread')
            ->orderByDesc('dateSent')
            ->get();

        $unreadCount = $userNotifications->count();

        return view('admin.messages-admin', compact('notifications', 'userNotifications', 'unreadCount'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::all();
        return view('admin.notifications-create', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'title' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        Notification::create([
            'user_id' => $request->user_id,
            'title' => $request->title,
            'message' => $request->message,
            'status' => 'unread',
        ]);

        return redirect()->route('notifications.index')->with('success', 'Notification created!');
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
    public function edit($id)
    {
        $notification = Notification::findOrFail($id);
        $users = User::all();
        return view('admin.notifications-edit', compact('notification', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $notificationId)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'title' => 'required|string|max:255',
            'message' => 'required|string',
            'status' => 'required|in:read,unread',
        ]);

        $notification = Notification::findOrFail($notificationId);
        $notification->update($validated);

        return response()->json(['success' => true]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $notification = Notification::findOrFail($id);
        $notification->delete();

        return redirect()->route('notifications.index')->with('success', 'Notification deleted!');
    }
    public function markRead($id)
    {
        $notification = Notification::where('notification_id', $id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        $notification->status = 'read';
        $notification->save();

        return response()->json(['success' => true]);
    }
    public function getNotification($id) {
    $notification = Notification::find($id); // Assuming Notification model is used
    if ($notification) {
        return response()->json($notification); // Return the notification as JSON
    }
    return response()->json(['error' => 'Notification not found'], 404); // Return error if not found
}

    /**
     * Get all unread notifications for the authenticated user (API endpoint)
     */
    public function getUserNotifications()
    {
        $userNotifications = Notification::where('user_id', auth()->id())
            ->orderByDesc('dateSent')
            ->get();

        $unreadCount = $userNotifications->where('status', 'unread')->count();

        return response()->json([
            'notifications' => $userNotifications,
            'unreadCount' => $unreadCount
        ]);
    }

    /**
     * Get only unread notifications for the authenticated user
     */
    public function getUnreadNotifications()
    {
        $unreadNotifications = Notification::where('user_id', auth()->id())
            ->where('status', 'unread')
            ->orderByDesc('dateSent')
            ->get();

        return response()->json([
            'notifications' => $unreadNotifications,
            'count' => $unreadNotifications->count()
        ]);
    }

    /**
     * Mark a notification as read (API endpoint)
     */
    public function markNotificationRead($id)
    {
        $notification = Notification::where('notification_id', $id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        $notification->status = 'read';
        $notification->save();

        return response()->json(['success' => true, 'message' => 'Notification marked as read']);
    }
}
