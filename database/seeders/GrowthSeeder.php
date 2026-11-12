<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Growth;
use App\Models\Baby;
use Illuminate\Support\Facades\DB;

class GrowthSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $babies = Baby::all();
        if ($babies->isEmpty()) {
            $this->command->warn('No babies found. Please seed babies first.');
            return;
        }

        foreach ($babies as $baby) {
            $growthData = [];
            // Seed growth records up to the baby's age in months. Cap to 18 months to avoid excessive data.
            $ageMonths = (int) ($baby->age ?? 0);
            $monthCount = max(1, min($ageMonths, 18));
            $baseHeight = rand(48, 54); // cm, newborn
            $baseWeight = rand(2800, 4000); // g, newborn
            $lastHeight = $baseHeight;
            $lastWeight = $baseWeight;
            for ($i = 1; $i <= $monthCount; $i++) {
                // Height can only increase or stay the same
                $heightIncrease = rand(0, 3); // 0-3 cm per month
                $height = $lastHeight + $heightIncrease;
                $lastHeight = $height;

                // Weight can fluctuate but generally increases
                $weightIncrease = rand(100, 300); // 100-300g per month
                $weight = $lastWeight + $weightIncrease;
                $lastWeight = $weight;

                $growthData[] = [
                    'baby_id' => $baby->id,
                    'growthMonth' => $i,
                    'height' => $height,
                    'weight' => $weight,
                    'created_at' => now()->subMonths($monthCount - $i),
                    'updated_at' => now()->subMonths($monthCount - $i),
                ];
            }
            Growth::insert($growthData);
        }
    }
}
