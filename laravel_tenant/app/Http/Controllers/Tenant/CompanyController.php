<?php

namespace App\Http\Controllers\Tenant;

use App\Models\Company;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Events\Tenant\CompanyCreated;
use App\Events\Tenant\DatabaseCreated;

class CompanyController extends Controller
{
    private $company;

    public function __construct(Company $company)
    {
        $this->company = $company;
    }

    public function store(Request $request)
    {
        $company = $this->company->create([
            'name'          => 'Compania X ' . str_random(5),
            'domain'        => str_random(5) . 'compania_x.com',
            'db_database'   => 'laravel_tenancy_company_x'  . str_random(5),
            'db_hostname'   => 'localhost',
            'db_username'   => 'master',
            'db_password'   => 'Bina@6939'

        ]);

        if(true)
        {
            event(new CompanyCreated($company));
        }
        else
        {
            event(new DatabaseCreated($company));
        }
        
        dd($company);
    }
}
