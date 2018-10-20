<?php

namespace App\Listeners\Tenant;

use App\Events\Tenant\DatabaseCreated;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Artisan;

class RunSeedersTenant
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  DatabaseCreated  $event
     * @return void
     */
    public function handle(DatabaseCreated $event)
    {
        $client = $event->client(); 
        
        $seed = Artisan::call('tenants:seeders',  [
            'id' => $client->id
        ]);

        return $seed === 0;
    }
}
