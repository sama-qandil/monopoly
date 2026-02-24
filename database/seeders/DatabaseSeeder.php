<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        \App\Models\User::factory()->create([
        'name' => 'Sama',
        'email' => 'sama@example.com',
        'password' => Hash::make('password123'), 
        'gold' => 5000,
        'gems' => 1000,
    ]);
            //TODO: default password missing  
        

        //TODO: configure the needed seeders for (initial / test) models

        $this->call([
        CharacterSeeder::class,
        DiceSeeder::class,
        NecklaceSeeder::class,
    ]);
    }
}
