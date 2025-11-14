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
            // Resolve the user: some appointments are linked to a baby which has the user
            $user = $appointment->user ?? ($appointment->baby ? $appointment->baby->user : null);

            // Ensure user and email exist
            if ($user && !empty($user->email)) {
                // Create in-app notification first (so it's created even if email fails)
                try {
                    $this->createInAppNotification($appointment, $user);
                } catch (\Exception $e) {
                    $this->error("Error creating in-app notification for user {$user->id}: " . $e->getMessage());
                }

                // Then attempt to send email reminder
                try {
                    Mail::to($user->email)->send(new AppointmentReminder($appointment));
                    $this->info("Sent email reminder to: {$user->email}");
                } catch (\Exception $e) {
                    $this->error("Failed to send to: {$user->email}. Error: " . $e->getMessage());
                }
            } else {
                $this->warn("Skipping appointment {$appointment->appointmentID}: no associated user/email found.");
            }
        }

        $this->info('All reminders sent.');
        return 0;
    }

    /**
     * Create an in-app notification for appointment reminder
     */
    private function createInAppNotification($appointment, $user = null)
    {
        try {
            $baby = $appointment->baby;
            // prefer passed user, then appointment->user, then baby->user
            $user = $user ?? $appointment->user ?? ($baby ? $baby->user : null);

            if (!$baby || !$user) {
                return;
            }

            // Check if notification already exists to avoid duplicates
            $existingNotification = Notification::where('user_id', $user->id)
                ->whereDate('dateSent', Carbon::today())
                // match titles containing baby name to avoid duplicates
                ->where('title', 'like', '%' . $baby->name . '%')
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
