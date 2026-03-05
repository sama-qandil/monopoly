<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\Dice;
use App\Enums\CurrencyType;


class DiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       $dice1= Dice::create([
            'name' => 'classic dice',
            'description' => 'A simple wooden dice for beginners in the game.',
            
            'icon' => 'classic_dice.png',
        ]);

       $dice1->shopItem()->create([
        'category'=>'dices',
        'itemable_type'=>Dice::class,
        'itemable_id'=>$dice1->id,
        'price'=>200,
        'currency_type'=>CurrencyType::GEMS,
        'is_active'=>true,
    ]);

 
        $dice2= Dice::create([
            'name' => 'halloween dice',
            'description' => 'A special dice for the Halloween event that increases your luck in escaping jail.',
            
            'icon' => 'halloween_dice.png',
        ]);

         $dice2->shopItem()->create([
        'category'=>'dices',
        'itemable_type'=>Dice::class,
        'itemable_id'=>$dice2->id,
        'price'=>150,
        'currency_type'=>CurrencyType::GEMS,
        'is_active'=>true,
    ]);

        $dice3= Dice::create([
            'name' => 'royal gold dice',
            'description' => 'A dice made of pure gold, showing the players wealth before their opponents.',
            
            'icon' => 'royal_gold_dice.png',
        ]);

         $dice3->shopItem()->create([
        'category'=>'dices',
        'itemable_type'=>Dice::class,
        'itemable_id'=>$dice3->id,
        'price'=>200,
        'currency_type'=>CurrencyType::GEMS,
        'is_active'=>true,
    ]);
    }
}
