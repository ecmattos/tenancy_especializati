<?php

namespace App\Console\Commands\Tenant;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use App\Tenant\ManagerTenant;
use App\Entities\Client;

class TenantSeeders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tenants:seeders {id?} {--seed}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run Seeders Tenants';

    private $tenant;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(ManagerTenant $tenant)
    {
        parent::__construct();
        $this->tenant = $tenant;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $id = $this->argument('id');

        if($id)
        {
            $client = Client::find($id);

            if($client) 
            {
                $this->execCommand($client);
            }

            return;
        }

        $clients = Client::all();

        foreach ($clients as $client) {
            $this->execCommand($client);
        }
    }

    public function execCommand(Client $client)
    {
        $command = 'db:seed';
        
        $this->tenant->setConnection($client);

        $this->info("Seeding Client {$client->name}");

        Artisan::call($command, [
            '--force' => true,
            '--class' => 'TenantDatabaseSeeder'
        ]);

        $this->info("End Seeding Client {$client->name}");
        $this->info("---------------------------------------");
        
    }
}
