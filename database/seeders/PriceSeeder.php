<?php

namespace Database\Seeders;

use App\Models\Price;
use Illuminate\Database\Seeder;

class PriceTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     */
    public function run(): void
    {
        Price::create(['id' => '1', 'precio' => '25']);
        Price::create(['id' => '2', 'precio' => '20']);
        Price::create(['id' => '3', 'precio' => '15']);

    }
}
