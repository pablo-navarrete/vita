<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ClinicaController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PaymentDateController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\LogoController;
use App\Http\Controllers\WebController;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;


//web
Route::get('/', [WebController::class, 'index'])->name('admin.web.inicio');
Route::get('/sobre-vita', [WebController::class, 'about'])->name('admin.web.about');
Route::get('/servicios', [WebController::class, 'service'])->name('admin.web.service');
Route::get('/contactar', [WebController::class, 'contact'])->name('admin.web.contact');

Route::get('/admin/login', [LoginController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login/intro', [LoginController::class, 'login'])->name('admin.login.intro');
Route::post('/admin/logout', [LoginController::class, 'logout'])->name('admin.logout');

// Agrupando rutas que requieren autenticación
Route::middleware(['web','auth']) 
    ->group(function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    // Dashboard
    Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
    Route::get('/servicio-data', [DashboardController::class, 'getServicioData'])->name('dashboard.getServicioData');
    Route::get('/clinicas-data', [DashboardController::class, 'getClinicasData'])->name('dashboard.getClinicasData');

    // Clínicas
    Route::get('/admin/clinicas', [ClinicaController::class, 'index'])->name('clinica.index');
    Route::post('/clinicas/crear', [ClinicaController::class, 'store'])->name('clinica.store');
    Route::get('/clinicas/data', [ClinicaController::class, 'getData'])->name('clinicas.data');
    Route::get('/clinicas/{id}/edit', [ClinicaController::class, 'edit'])->name('clinicas.edit');
    Route::put('/clinicas/{clinica}', [ClinicaController::class, 'update'])->name('clinicas.update');
    Route::post('clinicas/{id}', [ClinicaController::class, 'destroy'])->name('clinicas.destroy');
    Route::post('clinicas/{id}/update-status', [ClinicaController::class, 'updateStatus'])->name('clinicas.updateStatus');
    Route::post('clinicas/{id}/update-status-pago', [ClinicaController::class, 'updateStatusPago'])->name('clinicas.updateStatusPago');
    Route::post('clinicas/{id}/update-status-mes', [ClinicaController::class, 'updateStatusMes'])->name('clinicas.updateStatusMes');
    Route::get('/clinicas/{id}/ver', [ClinicaController::class, 'ver'])->name('clinicas.ver');


    // Fechas de pago
    Route::get('/admin/fecha-pagos', [PaymentDateController::class, 'index'])->name('paymentDate.index');
    Route::get('/admin/fecha-pagos/data', [PaymentDateController::class, 'getData'])->name('paymentDate.data');
    Route::post('/admin/fecha-pagos/crear', [PaymentDateController::class, 'store'])->name('paymentDate.store');

    //logo
    Route::get('/admin/logo', [LogoController::class, 'index'])->name('admin.logo.index');
    Route::post('/admin/logo/store', [LogoController::class, 'store'])->name('admin.logo.store');

    //banner
    Route::get('/admin/banner', [BannerController::class, 'index'])->name('admin.banner.index');
    Route::get('/admin/banner/data', [BannerController::class, 'getBanner'])->name('admin.banner.data');
    Route::post('/admin/banner/store', [BannerController::class, 'store'])->name('admin.banner.store');
    Route::get('/admin/banner/create', [BannerController::class, 'create'])->name('admin.banner.create');
    Route::post('/admin/banner/{id}/update-status', [BannerController::class, 'updateStatus'])->name('admin.banner.updateStatus');
    Route::post('/admin/banner/{id}', [BannerController::class, 'destroy'])->name('admin.banner.destroy');
});
