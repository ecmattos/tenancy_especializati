<?php

namespace App\Http\Middleware\Tenant;

use App\Entities\Client;
use App\Tenant\ManagerTenant;
use Closure;

class TenantMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $manager = app(ManagerTenant::class);
        
        if($manager->domainIsMain())
        {
            return $next($request);
        }

        $client = $this->getClient($request->getHost());
        
        if(!$client && $request->url() != route('404.tenant'))
        {
            return redirect()->route('404.tenant');
        }
        else if ($request->url() != route('404.tenant') && !$manager->domainIsMain())
        {
            $manager->setConnection($client);
        }

        return $next($request);
    }

    public function getClient($host)
    {
        return Client::where('domain', '=', $host)->first();
    }
}
