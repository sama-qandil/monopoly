<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CharacterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Character::create([
        'name' => 'character1',
        'gender' => 'female',
        'category' => 'medium',
        'ability' => 'Speed Up Moves',
        'max_level' => 10,
        'avatar' => 'char1.png',
        'gold_price' => 2222,
        'gems_price' => 3333,
    ]);

    \App\Models\Character::create([
        'name' => 'Warrior King',
        'gender' => 'male',
        'category' => 'legendary',
        'ability' => 'Double Gold',
        'max_level' => 15,
        'avatar' => 'warrior.png',
        'gold_price' => 5000,
        'gems_price' => 0,
    ]);
    }
}
