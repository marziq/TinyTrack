<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Vaccination;

class VaccinationSeeder extends Seeder
{
    public function run()
    {
        $babies = \App\Models\Baby::all();
        foreach ($babies as $baby) {
            \App\Models\Vaccination::factory()->count(2)->create([
                'baby_id' => $baby->id,
            ]);
        }
    }
}
