<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Notification;

class NotificationSeeder extends Seeder
{
    public function run()
    {
        $users = \App\Models\User::all();
        foreach ($users as $user) {
            // Welcome notification
            \App\Models\Notification::factory()->create([
                'user_id' => $user->id,
                'title' => 'Welcome to TinyTrack!',
                'message' => 'Thank you for joining TinyTrack. Start tracking your baby’s milestones and appointments!',
                'dateSent' => now(),
                'status' => 'unread',
            ]);

            // Appointment reminders for each baby
            foreach ($user->babies as $baby) {
                $appointment = $baby->appointments()->where('appointmentDate', '>=', now()->toDateString())->first();
                if ($appointment) {
                    \App\Models\Notification::factory()->create([
                        'user_id' => $user->id,
                        'title' => 'Appointment Reminder',
                        'message' => "Reminder: You have an appointment for {$baby->name} on {$appointment->appointmentDate}.",
                        'dateSent' => now(),
                        'status' => 'unread',
                    ]);
                }
            }
        }
    }
}
