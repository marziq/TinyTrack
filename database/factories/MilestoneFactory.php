<?php
namespace Database\Factories;

use App\Models\Milestone;
use Illuminate\Database\Eloquent\Factories\Factory;

class MilestoneFactory extends Factory
{
    protected $model = Milestone::class;

    public function definition()
    {
        return [
            'baby_id' => null, // Set in seeder
            'title' => $this->faker->randomElement(['First Smile', 'First Word', 'First Step', 'First Tooth']),
            'description' => $this->faker->sentence(),
            'achievedDate' => $this->faker->date('Y-m-d', '-6 months'),
        ];
    }
}
