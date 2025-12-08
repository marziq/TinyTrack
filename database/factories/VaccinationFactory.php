<?php
namespace Database\Factories;

use App\Models\Vaccination;
use Illuminate\Database\Eloquent\Factories\Factory;

class VaccinationFactory extends Factory
{
    protected $model = Vaccination::class;

    public function definition()
    {
        return [
            'baby_id' => null, // Set in seeder
            'vaccine_name' => $this->faker->randomElement(['BCG', 'Hepatitis B', 'Polio', 'DTP', 'MMR']),
            'scheduled_date' => $this->faker->date('Y-m-d', '+1 month'),
            'administered_at' => $this->faker->optional()->dateTimeBetween('-6 months', 'now'),
            'status' => $this->faker->randomElement(['given', 'pending']),
        ];
    }
}
