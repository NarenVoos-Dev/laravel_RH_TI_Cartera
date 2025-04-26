<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

use App\Http\Controllers\RoleController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\EmployeeCompanyController;
use App\Http\Controllers\WalletController;
use App\Http\Controllers\ReporteCarteraController;
use App\Http\Controllers\PayrollsController;
use App\Http\Controllers\PayrollDetailController;
use Illuminate\Http\Request;
use App\Http\Controllers\EarningController;
use App\Http\Controllers\DeductionController;
use App\Http\Controllers\PayrollDetailItemController;
use App\Http\Controllers\DesprendibleController;
use Spatie\Permission\Middleware\PermissionMiddleware;



Route::get('/', function () {
    return view('welcome');
});

Route::redirect('/','/dashboard')->name('home');

Route::post('/login', [AuthenticatedSessionController::class, 'store'])->name('login');

Route::middleware(['auth'])->group(function () {

    // Dashboard
    Route::get('/dashboard', fn() => view('dashboard'))->name('dashboard');

    // Perfil del usuario
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // LOGOUT
    Route::post('/logout', function () {
        Auth::logout();
        return redirect('/login');
    })->name('logout');

    // === Roles y permisos ===
    Route::middleware('auth',PermissionMiddleware::class . ':ver roles')->group(function () {
        Route::resource('roles', RoleController::class);
        Route::get('/roles/{role}/permisos', [RoleController::class, 'editPermissions'])->name('roles.permissions');
        Route::put('/roles/{role}/permisos', [RoleController::class, 'updatePermissions'])->name('roles.permissions.update');
    });

    // === Usuarios ===
    Route::middleware('auth',PermissionMiddleware::class . ':ver usuarios')->group(function () {
        Route::resource('users', UserController::class);
        Route::put('/users/{id}/inactivate', [UserController::class, 'inactivate'])->name('users.inactivate');
    });

    // === Empleados y Asignaciones ===
    Route::middleware('auth',PermissionMiddleware::class . ':empleados')->group(function () {
        Route::resource('employees', EmployeeController::class);
        Route::put('/employees/{id}/inactivate', [EmployeeController::class, 'inactivate'])->name('employees.inactivate');
    });

    Route::middleware('auth',PermissionMiddleware::class . ':asignar asignaciones')->group(function () {
        Route::resource('assignments', EmployeeCompanyController::class);
        Route::post('/assignments/change-company', [EmployeeCompanyController::class, 'changeCompany'])->name('assignments.change-company');
        Route::post('/assignments/{id}/deactivate', [EmployeeCompanyController::class, 'deactivate'])->name('assignments.deactivate');
    });

    // === Empresas ===
    Route::middleware('auth',PermissionMiddleware::class . ':ver companías')->group(function () {
        Route::resource('companies', CompanyController::class);
    });

    // === Cartera ===
    Route::middleware('auth',PermissionMiddleware::class . ':cartera')->group(function () {
        Route::resource('cartera', WalletController::class);
        Route::post('/cartera/{id}/movements', [WalletController::class, 'createMovement'])->name('cartera.create-movement');
        Route::get('/cartera/{id}/movements', [WalletController::class, 'getMovements'])->name('cartera.movements');
    });

    // === Reportes de Cartera ===
    Route::middleware('auth',PermissionMiddleware::class . ':ver reportes')->group(function () {
        Route::get('/reportes/carteras', [ReporteCarteraController::class, 'index'])->name('reportes.carteras.index');
        Route::get('reportes/carteras/export', [ReporteCarteraController::class, 'exportExcel'])->name('reportes.carteras.export');
        Route::get('reportes/carteras/pdf', [ReporteCarteraController::class, 'exportarPDF'])->name('reportes.carteras.pdf');
    });

    // === Nómina ===
    Route::middleware('auth',PermissionMiddleware::class . ':crear nomina')->group(function () {
        Route::resource('payrolls', PayrollsController::class);
        Route::patch('/payrolls/{payroll}/cerrar', [PayrollsController::class, 'close'])->name('payrolls.close');
        Route::get('/payrolls/{payroll}/export-excel', [PayrollsController::class, 'exportExcel'])->name('payrolls.export_excel');
    });

    Route::middleware('auth',PermissionMiddleware::class . ':ver nomina')->group(function () {
        Route::get('/payrolls', [PayrollsController::class, 'index'])->name('payrolls.index');
    });

    // === Desprendibles ===
    Route::middleware('auth',PermissionMiddleware::class . ':ver colillas')->group(function () {
        Route::get('/desprendibles', [DesprendibleController::class, 'index'])->name('desprendibles.index');
        Route::get('/desprendibles/{detail}/pdf', [DesprendibleController::class, 'exportPdf'])->name('desprendibles.export_pdf');
    });

    // === Conceptos de nómina ===
    Route::middleware('auth',PermissionMiddleware::class . ':ver configuracion')->group(function () {
        Route::view('/configuration', 'payrolls.configuration.index')->name('configuration.index');
        Route::resource('earnings', EarningController::class);
        Route::resource('deductions', DeductionController::class);
    });

    // === Detalles de nómina por empleado ===
    Route::resource('/payroll_details', PayrollDetailController::class)->middleware('auth',PermissionMiddleware::class . ':ver nomina');
    Route::patch('/payroll_details/{payrollDetail}/update-days', [PayrollDetailController::class, 'updateDays'])->name('payroll_details.update_days')->middleware('auth',PermissionMiddleware::class . ':crear nomina');
    Route::post('/payroll-details/{detail}/items', [PayrollDetailItemController::class, 'store'])->name('payroll_detail_items.store')->middleware('auth',PermissionMiddleware::class . ':crear nomina');
    Route::delete('/payroll-detail-items/{item}', [PayrollDetailItemController::class, 'destroy'])->name('payroll_detail_items.destroy')->middleware('auth',PermissionMiddleware::class . ':crear nomina');
    Route::get('/payroll-detail/{detail}/pdf', [PayrollDetailController::class, 'exportPdf'])->name('payroll_details.export_pdf')->middleware('auth',PermissionMiddleware::class . ':ver colillas');
});

require __DIR__.'/auth.php';
