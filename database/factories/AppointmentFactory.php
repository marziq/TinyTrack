<?php
namespace Database\Factories;

use App\Models\Appointment;
use Illuminate\Database\Eloquent\Factories\Factory;

class AppointmentFactory extends Factory
{
    protected $model = Appointment::class;

    public function definition()
    {
        return [
            'baby_id' => null, // Set in seeder
            'appointmentDate' => $this->faker->dateTimeBetween('+1 days', '+1 month')->format('Y-m-d'),
            'appointmentTime' => $this->faker->time('H:i'),
            'purpose' => $this->faker->randomElement(['Checkup', 'Vaccination', 'Consultation']),
            'status' => $this->faker->randomElement(['Waiting', 'Done']),
        ];
    }
}
