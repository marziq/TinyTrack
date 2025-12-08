<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Appointment;

class AppointmentSeeder extends Seeder
{
    public function run()
    {
        $babies = \App\Models\Baby::all();
        foreach ($babies as $baby) {
            \App\Models\Appointment::factory()->count(2)->create([
                'baby_id' => $baby->id,
            ]);
        }
    }
}
