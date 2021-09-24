<?php

namespace Database\Seeders;

use App\Models\Diaria;
use Illuminate\Database\Seeder;

class DiariasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $diarias = [
            ['descricao' => 'UTI', 'base' => 2500.00 , 'adicional' => 750.00, 'venda' => 3250.00],
            ['descricao' => 'Apartamento', 'base' => 1500.00 , 'adicional' => 500.00, 'venda' => 2000.00]
        ];
        Diaria::insert($diarias);
    }
}
