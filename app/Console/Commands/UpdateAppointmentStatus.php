<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Appointment;
use Carbon\Carbon;

class UpdateAppointmentStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    // 3. This is the name our command will have
    protected $signature = 'app:update-appointment-status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Find past appointments and mark them as Completed';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // 4. This is the logic that will run
        $today = Carbon::today()->toDateString();

        $this->info("Checking for appointments to update...");

        // Find appointments where the date is in the past
        // and the status is still 'Waiting'
        $updatedCount = Appointment::where('status', 'Waiting')
                                   ->where('appointmentDate', '<', $today)
                                   ->update(['status' => 'Done']);

        if ($updatedCount > 0) {
            $this->info("Successfully updated {$updatedCount} appointments to 'Done'.");
        } else {
            $this->info("No appointments needed updating.");
        }

        return 0;
    }
}
