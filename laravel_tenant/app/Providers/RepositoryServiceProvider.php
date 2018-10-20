<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(\App\Repositories\PlanTypeRepository::class, \App\Repositories\PlanTypeRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\PlanSubTypeRepository::class, \App\Repositories\PlanSubTypeRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\PlanRepository::class, \App\Repositories\PlanRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\ProductRepository::class, \App\Repositories\ProductRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\PlanStatusRepository::class, \App\Repositories\PlanStatusRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\TrashRepository::class, \App\Repositories\TrashRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\ClientRepository::class, \App\Repositories\ClientRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\MaterialUnitRepository::class, \App\Repositories\MaterialUnitRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\MaterialRepository::class, \App\Repositories\MaterialRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\CompanyPositionRepository::class, \App\Repositories\CompanyPositionRepositoryEloquent::class);
        //:end-bindings:
    }
}
