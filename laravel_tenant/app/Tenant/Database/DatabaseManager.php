<?php

namespace App\Tenant\Database;

use Illuminate\Support\Facades\DB;

use App\Entities\Client;

class DatabaseManager
{
    public function createDatabase(Client $client)
    {
        #dd('clientDatabase: '.$client->database);
        
        return DB::statement("
            CREATE DATABASE {$client->database} CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci
        ");
    }
}