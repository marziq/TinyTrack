<?php
namespace Database\Factories;

use App\Models\Notification;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class NotificationFactory extends Factory
{
    protected $model = Notification::class;

    public function definition()
    {
        return [
            'user_id' => null, // Set in seeder
            'title' => 'Welcome to TinyTrack!',
            'message' => 'Thank you for joining TinyTrack. Start tracking your baby’s milestones and appointments!',
            'dateSent' => now(),
            'status' => 'unread',
        ];
    }

    public function appointmentReminder($userId, $babyName, $appointmentDate)
    {
        return $this->state([
            'user_id' => $userId,
            'title' => 'Appointment Reminder',
            'message' => "Reminder: You have an appointment for $babyName on $appointmentDate.",
            'dateSent' => now(),
            'status' => 'unread',
        ]);
    }
}
