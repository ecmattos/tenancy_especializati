<?php

use Illuminate\Database\Seeder;

class MaterialUnitsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $material_units =
        [
            [
                'code'        => 'pc',
                'description' => 'peça'
            ],
            [
                'code'        => 'm',
                'description' => 'metro linear'
            ],
            [
                'code'        => 'm2',
                'description' => 'metro quadrado'
            ],
            [
                'code'        => 'm3',
                'description' => 'metro cúbico'
            ],
            [
                'code'        => 'kg',
                'description' => 'quilograma'
            ],
            [
                'code'        => 'g',
                'description' => 'grama'
            ]
        ];
    
        foreach ($material_units as $material_unit)
        {
            \App\Entities\MaterialUnit::create($material_unit);
        }
    }
}

