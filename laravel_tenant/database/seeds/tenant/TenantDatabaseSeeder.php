<?php

use Illuminate\Database\Seeder;

class TenantDatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(PlanTypesTableSeeder::class);
        $this->call(PlanSubTypesTableSeeder::class);
        $this->call(PlanStatusesTableSeeder::class);
        $this->call(PlansTableSeeder::class);
        $this->call(MaterialUnitsTableSeeder::class);
        $this->call(MaterialsTableSeeder::class);
        $this->call(CompanyPositionsTableSeeder::class);
    }
}
