<?php

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
        $materials =
        [
            [
                'code'        => '45235',
                'description' => 'Pino Plus Pin',
                'material_unit_id' => '1'
            ],
            [
                'code'        => '77857',
                'description' => 'Pedra Ninja Branca 20x2,7mm',
                'material_unit_id' => '1'
            ],
            [
                'code'        => '24335',
                'description' => 'Pedra Ninja Branca 20x2,7mm Especial',
                'material_unit_id' => '1'
            ],
            [
                'code'        => '5654',
                'description' => 'Dentes Clareados (5p/2g)',
                'material_unit_id' => '1'
            ],
            [
                'code'        => '54432',
                'description' => 'Pastilha Extratificação (1p/5g)',
                'material_unit_id' => '1'
            ],
            [
                'code'        => '65665',
                'description' => 'Fit Cast Cobalto (Co-Cr) 250g',
                'material_unit_id' => '1'
            ]
        ];
    
        foreach ($materials as $material)
        {
            \App\Entities\Material::create($material);
        }
    }
}

