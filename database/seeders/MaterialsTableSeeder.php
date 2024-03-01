<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MaterialsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Material::create([
            'codigo' => 'ABC123',
            'marca' => 'Marca1',
            'description' => 'Descripción del material 1',
            'stock' => 100,
            'numero_serie' => '123456789',
            'proveedor_id' => 1, 
            'precioCoste' => 50.00,
            'pvp' => 80.00,
            'encurso' => false,
            'observaciones' => 'Algunas observaciones sobre el material 1',
        ]);

        Material::create([
            'codigo' => 'DEF456',
            'marca' => 'Marca2',
            'description' => 'Descripción del material 2',
            'stock' => 150,
            'numero_serie' => '987654321',
            'proveedor_id' => 2, 
            'precioCoste' => 70.00,
            'pvp' => 100.00,
            'encurso' => true,
            'observaciones' => 'Algunas observaciones sobre el material 2',
        ]);
    }
}
