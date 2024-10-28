<?php

namespace Database\Seeders;

use App\Models\Idioma;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class IdiomaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Idioma::create(['id' => '1', 'idioma' => 'Català']);
        Idioma::create(['id' => '2', 'idioma' => 'Castellà']);
        Idioma::create(['id' => '3', 'idioma' => 'Anglès']);
    }
}
