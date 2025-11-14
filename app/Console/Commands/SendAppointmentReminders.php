<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Appointment;
use App\Mail\AppointmentReminder;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class SendAppointmentReminders extends Command
{
    protected $signature = 'app:send-appointment-reminders';
    protected $description = 'Send email reminders for appointments happening tomorrow';

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

        $this->info("Found {$appointments->count()} appointments. Sending emails...");

        foreach ($appointments as $appointment) {
            // Ensure user and email exist
            if ($appointment->user && $appointment->user->email) {
                try {
                    Mail::to($appointment->user->email)->send(new AppointmentReminder($appointment));
                    $this->info("Sent reminder to: {$appointment->user->email}");
                } catch (\Exception $e) {
                    $this->error("Failed to send to: {$appointment->user->email}. Error: " . $e->getMessage());
                }
            }
        }

        $this->info('All reminders sent.');
        return 0;
    }
}
