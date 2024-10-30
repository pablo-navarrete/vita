<?php

declare(strict_types=1);

use App\Http\Controllers\Tenant\Auth\LoginController;
use App\Http\Controllers\Tenant\BannerController;
use App\Http\Controllers\Tenant\ConsultaController;
use App\Http\Controllers\Tenant\DashboardController;
use App\Http\Controllers\Tenant\HomeController;
use App\Http\Controllers\Tenant\LogoController;
use App\Http\Controllers\Tenant\WebController;
use Illuminate\Support\Facades\Route;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;






/*
|--------------------------------------------------------------------------
| Tenant Routes
|--------------------------------------------------------------------------
|
| Here you can register the tenant routes for your application.
| These routes are loaded by the TenantRouteServiceProvider.
|
| Feel free to customize them however you want. Good luck!
|
*/


Route::middleware([
    'web',
    InitializeTenancyByDomain::class,
    PreventAccessFromCentralDomains::class,
])->group(function () {

    //login
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('tenant.login');
    Route::post('/tenant/login/intro', [LoginController::class, 'login'])->name('tenant.login.intro');
    Route::post('/tenant/logout', [LoginController::class, 'logout'])->name('tenant.logout');

   
    //web
    Route::get('/', [WebController::class, 'index'])->name('tenant.web.inicio');
    Route::get('/acerca-de', [WebController::class, 'about'])->name('tenant.web.about');
    Route::get('/servicios', [WebController::class, 'service'])->name('tenant.web.service');
    Route::get('/contactar', [WebController::class, 'contact'])->name('tenant.web.contact');

    Route::middleware('auth.tenant')->group(function () {
      
        //dahsboard resumen
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('tenant.dashboard');

         //logo
        Route::get('/logo', [LogoController::class, 'index'])->name('tenant.logo.index');
        Route::post('/logo/store', [LogoController::class, 'store'])->name('tenant.logo.store');

          //banner
        Route::get('/banner', [BannerController::class, 'index'])->name('tenant.banner.index');
        Route::get('banner/data', [BannerController::class, 'getBanner'])->name('tenant.banner.data');
        Route::post('banner/store', [BannerController::class, 'store'])->name('tenant.banner.store');
        Route::get('banner/create', [BannerController::class, 'create'])->name('tenant.banner.create');
        Route::post('banner/{id}/update-status', [BannerController::class, 'updateStatus'])->name('tenant.banner.updateStatus');
        Route::post('banner/{id}', [BannerController::class, 'destroy'])->name('tenant.banner.destroy');

        //consultas
        Route::get('/consultas', [ConsultaController::class, 'index'])->name('tenant.consultas.index');
        Route::get('consultas/data', [ConsultaController::class, 'getConsultas'])->name('tenant.consultas.data');

    });
});
    
        

      
   
