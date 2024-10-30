<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;

class RouteServiceProvider extends ServiceProvider
{
    protected $namespace = 'App\Http\Controllers';
    protected $namespaceTenant = 'App\Http\Controllers\Tenant';
    public const HOME = '/admin/dashboard';

    public function boot()
    {
        parent::boot();
    }

    public function map()
    {
        $this->mapCentralRoutes(); // Rutas del dominio central
        $this->mapTenantRoutes();   // Rutas de los inquilinos
    }

    protected function mapCentralRoutes()
    {
        foreach ($this->centralDomains() as $domain) {
            Route::middleware('web')
                ->domain($domain)
                ->namespace($this->namespace)
                ->group(base_path('routes/web.php'));
        }
    }

    protected function mapTenantRoutes()
    {
        Route::middleware([
            'web',
            InitializeTenancyByDomain::class,
            PreventAccessFromCentralDomains::class,
        ])
        ->namespace($this->namespaceTenant)
        ->group(base_path('routes/tenant.php'));
    }

    protected function centralDomains(): array
    {
        return config('tenancy.central_domains', []);
    }
}