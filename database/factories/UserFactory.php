<?php

namespace Database\Factories;

use App\Models\Team;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Jetstream\Features;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $maleNames = ['Ahmad', 'Muhammad', 'Ali', 'Rizki', 'Farhan', 'Arjun', 'Budi', 'Candra', 'David', 'Eka', 'Farid', 'Gani', 'Hadi', 'Irfan', 'Jamal'];
        $femaleNames = ['Siti', 'Nurul', 'Aishah', 'Fatimah', 'Nur', 'Aisyah', 'Zainab', 'Leila', 'Mira', 'Nadia', 'Ovi', 'Putri', 'Rina', 'Sasha', 'Tina'];
        $lastNames = ['Abdullah', 'Ahmad', 'Ali', 'Aziz', 'Baharudin', 'Chew', 'Che', 'Chua', 'Dato', 'Din', 'Dollah', 'Ghani', 'Hamid', 'Hashim', 'Hassan', 'Ibrahim', 'Ismail', 'Jahangir', 'Jalaluddin', 'Jamaludin', 'Jani', 'Junos', 'Kadir', 'Khalid', 'Khalifah', 'Khoo', 'Kong', 'Kusumo', 'Lau', 'Lee', 'Lew', 'Lim', 'Long', 'Loong', 'Lye', 'Mahmod', 'Mahmud', 'Manaf', 'Maniam', 'Mattar', 'Mirza', 'Mohamed', 'Mohamad', 'Mohammed', 'Mohd', 'Mokhtar', 'Mualim', 'Muhamad', 'Muhammad', 'Mukherjee', 'Mul', 'Musa', 'Mustafa', 'Muthalib', 'Mydin', 'Ng', 'Noor', 'Nor', 'Noraini', 'Norzela', 'Norizan', 'Norliza', 'Norliza', 'Norliza'];

        $gender = fake()->randomElement(['male', 'female']);
        $firstName = $gender === 'male' ? fake()->randomElement($maleNames) : fake()->randomElement($femaleNames);
        $lastName = fake()->randomElement($lastNames);
        $name = $firstName . ' ' . $lastName;

        // Generate email from name
        $emailName = strtolower(str_replace(' ', '.', $name));
        $email = $emailName . '@example.com';

        return [
            'name' => $name,
            'email' => $email,
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'two_factor_secret' => null,
            'two_factor_recovery_codes' => null,
            'remember_token' => Str::random(10),
            'profile_photo_path' => null,
            'current_team_id' => null,
            'gender' => $gender,
            'mobile_number' => $this->generateMalaysianPhoneNumber(),
        ];
    }

    /**
     * Generate a Malaysian phone number.
     */
    private function generateMalaysianPhoneNumber(): string
    {
        $prefixes = ['010', '011', '012', '013', '014', '015', '016', '017', '018', '019'];
        $prefix = fake()->randomElement($prefixes);
        $number = fake()->numberBetween(10000000, 99999999);
        return $prefix . $number;
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }

    /**
     * Indicate that the user should have a personal team.
     */
    public function withPersonalTeam(?callable $callback = null): static
    {
        if (! Features::hasTeamFeatures()) {
            return $this->state([]);
        }

        return $this->has(
            Team::factory()
                ->state(fn (array $attributes, User $user) => [
                    'name' => $user->name.'\'s Team',
                    'user_id' => $user->id,
                    'personal_team' => true,
                ])
                ->when(is_callable($callback), $callback),
            'ownedTeams'
        );
    }
}
