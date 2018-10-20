<?php

use Illuminate\Database\Seeder;

class CompanyPositionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $company_positions =
        [
            [
                'code'        => 'Eng',
                'description' => 'Engenheiro(a)'
            ],
            [
                'code'        => 'Adm',
                'description' => 'Administrador(a)'
            ],
            [
                'code'        => 'Con',
                'description' => 'Contador(a)'
            ]
        ];
    
        foreach ($company_positions as $company_position)
        {
            \App\Entities\CompanyPosition::create($company_position);
        }
    }
}