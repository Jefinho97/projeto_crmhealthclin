<?php

namespace Database\Seeders;

use App\Models\Material;
use Illuminate\Database\Seeder;

class MaterialsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $materials = [
            ['tipo' => 'remedio', 'nome' => 'dipirona', 'uni_medida' => 'mlg', 'custo' => 2250.00, 'venda' => 2500.00],
            ['tipo' => 'material', 'nome' => 'seringa', 'uni_medida' => 'unidade', 'custo' => 1.00, 'venda' => 1.50],
        ];
        Material::insert($materials);
    }
}
