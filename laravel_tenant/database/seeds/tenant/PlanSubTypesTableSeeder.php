<?php

use Illuminate\Database\Seeder;

class PlanSubTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $plan_sub_types =
        [
            [
                'code'        => 'AUTO',
                'description' => 'AUTO'
            ],
            [
                'code'        => 'MOTO',
                'description' => 'MOTO'
            ],
            [
                'code'        => 'CASA',
                'description' => 'CASA'
            ],
            [
                'code'        => 'EMPR',
                'description' => 'EMPRESARIAL'
            ],
            [
                'code'        => 'FAM',
                'description' => 'FAMILIAR'
            ],
            [
                'code'        => 'IND',
                'description' => 'INDIVIDUAL'
            ],
            [
                'code'        => 'VIDA',
                'description' => 'VIDA'
            ]
        ];
    
        foreach ($plan_sub_types as $plan_sub_type)
        {
            \App\Entities\PlanSubType::create($plan_sub_type);
        }
    }
}

