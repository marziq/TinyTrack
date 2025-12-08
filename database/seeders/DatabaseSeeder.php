<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seed users
        $this->call(UserSeeder::class);

        // Seed appointments
        $this->call(AppointmentSeeder::class);

        // Seed notifications
        $this->call(NotificationSeeder::class);

        // Seed baby vaccinations
        $this->call(VaccinationSeeder::class);

        // Seed milestones
        $this->call(MilestoneSeeder::class);

        // Seed baby's growth data
        $this->call(GrowthSeeder::class);
    }
}
