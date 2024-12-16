<?php

namespace Database\Seeders;

use App\Models\EventReaction;
use App\Models\User;
use App\Models\Event;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // Creating a sample user. 
        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        //     'mobile' => '254794559089'
        // ]);

        // Creating 10 Events
        Event::factory(10)->create();

        //EventReaction::factory()->create();
    }
}
