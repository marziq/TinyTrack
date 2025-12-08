<?php
namespace Database\Factories;

use App\Models\Baby;
use Illuminate\Database\Eloquent\Factories\Factory;

class BabyFactory extends Factory
{
    protected $model = Baby::class;

    public function definition()
    {
        return [
            'user_id' => null, // Set in seeder
            'name' => $this->faker->firstName(),
            'birth_date' => $this->faker->date('Y-m-d', '-1 year'),
            'gender' => $this->faker->randomElement(['male', 'female']),
            'ethnicity' => $this->faker->randomElement(['Asian', 'Caucasian', 'African', 'Hispanic', 'Other']),
            'premature' => $this->faker->boolean(),
            'baby_photo_path' => null,
        ];
    }
}
