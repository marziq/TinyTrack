<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Baby;
use App\Models\User;

class BabySeeder extends Seeder
{
    public function run()
    {
        $users = User::all();
        foreach ($users as $user) {
            Baby::factory()->count(1)->create(['user_id' => $user->id]);
        }
    }
}
