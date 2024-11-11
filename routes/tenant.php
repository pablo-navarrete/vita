<?php

declare(strict_types=1);

use App\Http\Controllers\Tenant\Auth\LoginController;
use App\Http\Controllers\Tenant\BannerController;
use App\Http\Controllers\Tenant\CitaController;
use App\Http\Controllers\Tenant\ConsultaController;
use App\Http\Controllers\Tenant\DashboardController;
use App\Http\Controllers\Tenant\HistorialClinicoController;
use App\Http\Controllers\Tenant\HomeController;
use App\Http\Controllers\Tenant\LogoController;
use App\Http\Controllers\Tenant\PacienteController;
use App\Http\Controllers\Tenant\PreConsultaController;
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

        //paciente
        Route::get('/listado-pacientes', [PacienteController::class, 'index'])->name('tenant.paciente.index');
        Route::get('paciente/create', [PacienteController::class, 'create'])->name('tenant.paciente.create');
        Route::get('pacientes/data', [PacienteController::class, 'getPacientes'])->name('tenant.paciente.data');
        Route::post('paciente/store', [PacienteController::class, 'store'])->name('tenant.paciente.store');
        Route::get('/paciente/detalles/{id}', [PacienteController::class, 'show'])->name('tenant.paciente.show');
        Route::get('/paciente/editar/{id}', [PacienteController::class, 'edit'])->name('tenant.paciente.edit');
        Route::put('/paciente/actualizar/{id}', [PacienteController::class, 'update'])->name('tenant.paciente.update');


        //historial clinico
        Route::post('historial-medico/store', [HistorialClinicoController::class, 'store'])->name('historial.medico.store');
        Route::get('/historial-clinico/{id}', [HistorialClinicoController::class, 'getHistorial'])->name('historial.medico.data');

        //grafico dashboard pacientes
        Route::get('/pacientes-data', [DashboardController::class, 'getPacientesData'])->name('dashboard.getPacientesData');


        //pre-consulta
        Route::get('pre-consulta/create/{id}', [PreConsultaController::class, 'create'])->name('tenant.preconsulta.create');
        Route::post('pre-consulta/store', [PreConsultaController::class, 'store'])->name('tenant.preconsulta.store');


        //citas medicas
        Route::get('/citas', [CitaController::class, 'index'])->name('tenant.cita.index');
        Route::get('/listado-citas', [CitaController::class, 'list'])->name('tenant.cita.list');
        Route::get('citas/data', [CitaController::class, 'getCitas'])->name('tenant.cita.data');

    });
});
    
        

      
   
