<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Task;

use App\Models\Product; 

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
        // Create 50 products
         $this->call(ProductSeeder::class);
          User::factory()->count(5)->create()->each(function ($user) {
        Task::factory()->count(10)->create([
            'user_id' => $user->id,
        ]);
    });
    }
}
