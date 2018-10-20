<?php

namespace App\Tenant;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use App\Entities\Client;

class ManagerTenant 
{
    public function setConnection(Client $clent)
    {
        DB::purge('tenant');

        config()->set('database.connections.tenant.host', $clent->hostname);
        config()->set('database.connections.tenant.database', $clent->database);
        config()->set('database.connections.tenant.username', $clent->username);
        config()->set('database.connections.tenant.password', $clent->password);

        DB::reconnect('tenant');

        Schema::connection('tenant')->getConnection()->reconnect();

    }

    public function domainIsMain()
    {
        return request()->getHost() == config('tenant.domain_main');
    }
}