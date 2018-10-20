<?php

use Illuminate\Database\Seeder;

class PlanTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $plan_types =
        [
            [
                'code'        => 'SAU',
                'description' => 'SAUDE'
            ],
            [
                'code'        => 'SEG',
                'description' => 'SEGUROS'
            ],
            [
                'code'        => 'ASSIST',
                'description' => 'ASSISTENCIA'
            ]
        ];
    
        foreach ($plan_types as $plan_type)
        {
            \App\Entities\PlanType::create($plan_type);
        }
    }
}

