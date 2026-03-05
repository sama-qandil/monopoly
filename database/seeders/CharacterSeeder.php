<?php

namespace Database\Seeders;

use App\Enums\CurrencyType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Character;

class CharacterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       $character1= Character::create([
        'name' => 'character1',
        'gender' => 'female',
        'category' => 'medium',
        'ability' => 'Speed Up Moves',
        'max_level' => 10,
        'avatar' => 'char1.png',
        
    ]);

    $character1->shopItem()->create([
        'category'=>'characters',
        'itemable_type'=>Character::class,
        'itemable_id'=>$character1->id,
        'price'=>500,
        'currency_type'=>CurrencyType::GOLD,
        'is_active'=>true,
    ]);

    $character2= Character::create([
        'name' => 'Warrior King',
        'gender' => 'male',
        'category' => 'legendary',
        'ability' => 'Double Gold',
        'max_level' => 15,
        'avatar' => 'warrior.png',
       
    ]);

    $character2->shopItem()->create([
        'category'=>'characters',
        'itemable_type'=>Character::class,
        'itemable_id'=>$character2->id,
        'price'=>200,
        'currency_type'=>CurrencyType::GEMS,
        'is_active'=>true,
    ]);
    }
}
