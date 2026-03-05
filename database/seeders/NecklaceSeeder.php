<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Necklace;
use App\Enums\CurrencyType;

class NecklaceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $necklace1 = Necklace::create([
            'name' => '  Wooden Necklace',
            'description' => 'A simple wooden necklace that increases the player\'s luck in escaping jail.',
            'classification' => 'medium',
            'icon' => 'wooden_necklace.png',
            
        ]);

         $necklace1->shopItem()->create([
        'category'=>'necklaces',
        'itemable_type'=>Necklace::class,
        'itemable_id'=>$necklace1->id,
        'price'=>200,
        'currency_type'=>CurrencyType::GEMS,
        'is_active'=>true,
    ]);
    }
}
