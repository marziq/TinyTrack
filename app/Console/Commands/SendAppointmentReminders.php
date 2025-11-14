<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Appointment;
use App\Models\Notification;
use App\Mail\AppointmentReminder;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class SendAppointmentReminders extends Command
{
    protected $signature = 'app:send-appointment-reminders';
    protected $description = 'Send email and in-app notifications for appointments happening tomorrow';

    public function handle()
    {
        $this->info('Checking for appointments tomorrow...');

        // Get tomorrow's date
        $tomorrow = Carbon::tomorrow()->toDateString();

        // Find all 'Waiting' appointments scheduled for tomorrow
        // Eager load 'user' and 'baby' relationships
        $appointments = Appointment::with(['user', 'baby'])
                            ->where('status', 'Waiting')
                            ->where('appointmentDate', $tomorrow)
                            ->get();

        if ($appointments->isEmpty()) {
            $this->info('No appointments for tomorrow.');
            return 0;
        }

        $this->info("Found {$appointments->count()} appointments. Sending emails and in-app notifications...");

        foreach ($appointments as $appointment) {
            // Ensure user and email exist
            if ($appointment->user && $appointment->user->email) {
                try {
                    // Send email reminder
                    Mail::to($appointment->user->email)->send(new AppointmentReminder($appointment));
                    $this->info("Sent email reminder to: {$appointment->user->email}");

                    // Create in-app notification
                    $this->createInAppNotification($appointment);

                } catch (\Exception $e) {
                    $this->error("Failed to send to: {$appointment->user->email}. Error: " . $e->getMessage());
                }
            }
        }

        $this->info('All reminders sent.');
        return 0;
    }

    /**
     * Create an in-app notification for appointment reminder
     */
    private function createInAppNotification($appointment)
    {
        try {
            $baby = $appointment->baby;
            $user = $appointment->user;

            if (!$baby || !$user) {
                return;
            }

            // Check if notification already exists to avoid duplicates
            $existingNotification = Notification::where('user_id', $user->id)
                ->whereDate('dateSent', Carbon::today())
                ->where('title', 'like', '%' . $baby->name . '%Appointment%')
                ->first();

            if ($existingNotification) {
                $this->info("In-app notification already exists for {$baby->name}'s appointment.");
                return;
            }

            // Format appointment details
            $appointmentDate = Carbon::parse($appointment->appointmentDate)->format('D, M j, Y');
            $appointmentTime = Carbon::parse($appointment->appointmentTime)->format('g:i A');

            // Create in-app notification
            Notification::create([
                'user_id' => $user->id,
                'title' => "Appointment Reminder - {$baby->name}",
                'message' => "Your baby {$baby->name} has an appointment scheduled on {$appointmentDate} at {$appointmentTime}. Purpose: {$appointment->purpose}",
                'dateSent' => Carbon::now(),
                'status' => 'unread'
            ]);

            $this->info("In-app notification created for user {$user->id} ({$user->email}).");
        } catch (\Exception $e) {
            $this->error("Error creating in-app notification: " . $e->getMessage());
        }
    }
}
