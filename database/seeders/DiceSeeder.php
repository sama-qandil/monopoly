<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\Dice;

class DiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       Dice::create([
            'name' => 'النرد الكلاسيكي',
            'description' => 'نرد خشبي بسيط للمبتدئين في اللعبة.',
            'gems_cost' => 100,  
            'icon' => 'classic_dice.png',
        ]);

 
        Dice::create([
            'name' => 'نرد اليقطين المرعب',
            'description' => 'نرد خاص بإيفينت الهالوين يزيد من حظك في الهروب من السجن.',
            'gems_cost' => 500,
            'icon' => 'halloween_dice.png',
        ]);

        Dice::create([
            'name' => 'النرد الملكي الذهبي',
            'description' => 'نرد مصنوع من الذهب الخالص، يظهر ثراء اللاعب أمام الخصوم.',
            'gems_cost' => 1500,
            'icon' => 'royal_gold_dice.png',
        ]);
    }
}
