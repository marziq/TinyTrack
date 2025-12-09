<?php
namespace Database\Factories;

use App\Models\Baby;
use Illuminate\Database\Eloquent\Factories\Factory;

class BabyFactory extends Factory
{
    protected $model = Baby::class;

    public function definition()
    {
        $maleNames = ['Ahmad', 'Muhammad', 'Ali', 'Rizki', 'Farhan', 'Arjun', 'Budi', 'Candra', 'David', 'Eka', 'Farid', 'Gani', 'Hadi', 'Irfan', 'Jamal', 'Karim', 'Khalid', 'Lenny', 'Malik', 'Nasri', 'Omi', 'Pasha', 'Rafi', 'Samir', 'Taufiq', 'Usman', 'Vino', 'Wahid', 'Xander', 'Yusof', 'Zainal'];
        $femaleNames = ['Siti', 'Nurul', 'Aishah', 'Fatimah', 'Nur', 'Aisyah', 'Zainab', 'Leila', 'Mira', 'Nadia', 'Ovi', 'Putri', 'Rina', 'Sasha', 'Tina', 'Umairah', 'Vanessa', 'Wan', 'Xenia', 'Yasmin', 'Zara', 'Anika', 'Bella', 'Chitra', 'Diana', 'Esha', 'Fiona', 'Gisele', 'Hana', 'Isha'];
        $ethnicities = ['Malay', 'Chinese', 'Indian', 'Bumiputera', 'Mixed'];

        $gender = $this->faker->randomElement(['male', 'female']);
        $name = $gender === 'male' ? $this->faker->randomElement($maleNames) : $this->faker->randomElement($femaleNames);

        return [
            'user_id' => null, // Set in seeder
            'name' => $name,
            'birth_date' => $this->faker->date('Y-m-d', '-1 year'),
            'gender' => $gender,
            'ethnicity' => $this->faker->randomElement($ethnicities),
            'premature' => $this->faker->boolean(),
            'baby_photo_path' => null,
        ];
    }
}
