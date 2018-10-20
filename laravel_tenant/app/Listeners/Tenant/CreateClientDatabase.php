<?php

namespace App\Listeners\Tenant;

use App\Events\Tenant\ClientCreated;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\Tenant\Database\DatabaseManager;
use App\Events\Tenant\DatabaseCreated;

class CreateClientDatabase
{
    private $database;
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(DatabaseManager $database)
    {
        $this->database = $database;
    }

    /**
     * Handle the event.
     *
     * @param  ClientCreated  $event
     * @return void
     */
    public function handle(ClientCreated $event)
    {
        $client = $event->client();

        #dd('client: '.$client);

        if (!$this->database->createDatabase($client))
        {
            throw new \Exception('Error create Database');
        }

        //run migrations
        event(new DatabaseCreated($client));
    }

    
}
