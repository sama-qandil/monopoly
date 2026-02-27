<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Necklace;

class NecklaceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Necklace::create([
            'name' => 'قلادة الحظ الخشبية',
            'description' => 'قلادة بسيطة تزيد من احتمالية الحصول على أرقام زوجية في النرد.',
            'gold_cost' => 1000,
            'gems_cost' => 0,
            'icon' => 'wooden_necklace.png',
            'classification' => 'medium',
        ]);
    }
}
