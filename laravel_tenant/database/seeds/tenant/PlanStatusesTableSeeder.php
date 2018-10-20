<?php

use Illuminate\Database\Seeder;

class PlanStatusesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $plan_statuses =
        [
            [
                'code'        => 'AT',
                'description' => 'ATIVO'
            ],
            [
                'code'        => 'IN',
                'description' => 'INATIVO'
            ]
        ];
    
        foreach ($plan_statuses as $plan_status)
        {
            \App\Entities\PlanStatus::create($plan_status);
        }
    }
}

