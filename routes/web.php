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



Route::get('/', function () {
    return view('welcome');
});

Route::post('/login', [AuthenticatedSessionController::class, 'store'])->name('login');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


Route::post('/logout', function () {
    Auth::logout();
    return redirect('/login');
})->name('logout');

Route::middleware('auth')->group(function () {
    //Roles
    Route::resource('roles', RoleController::class);
    
    //Empleados
    Route::resource('employees', EmployeeController::class);
    Route::put('/employees/{id}/inactivate', [EmployeeController::class, 'inactivate'])->name('employees.inactivate');
    
    //Users
    Route::resource('users', UserController::class);
    Route::put('/users/{id}/inactivate', [UserController::class, 'inactivate'])->name('employees.inactivate');
    
    //Compañias
    Route::resource('companies', CompanyController::class);
    
    //Asignaciones empleados a compañias
    Route::resource('assignments', EmployeeCompanyController::class);
        //Cambiar compañia
    Route::post('/assignments/change-company', [EmployeeCompanyController::class, 'changeCompany'])->name('assignments.change-company');
        //Desactivar asignación
    Route::post('/assignments/{id}/deactivate', [EmployeeCompanyController::class, 'deactivate'])
    ->name('assignments.deactivate');

    //Carteras
    Route::resource('cartera', WalletController::class);
    //----Abono de cartera
        //Crear abono
        Route::post('/cartera/{id}/movements', [WalletController::class, 'createMovement'])->name('cartera.create-movement');
        //Historial de abono
        Route::get('/cartera/{id}/movements', [WalletController::class, 'getMovements'])->name('cartera.movements');
        //reportes
        Route::get('/reportes/carteras', [ReporteCarteraController::class, 'index'])->name('reportes.carteras.index');
        //Exportar a excel
        Route::get('reportes/carteras/export',[ReporteCarteraController::class, 'exportExcel'])->name('reportes.carteras.export');
        //exportar a pdf
        Route::get('reportes/carteras/pdf', [ReporteCarteraController::class, 'exportarPDF'])->name('reportes.carteras.pdf');
    //Nomina general 
    Route::resource('payrolls', PayrollsController::class);
    //Ruta para configuracion
    Route::view('/configuration', 'payrolls.configuration.index')->name('configuration.index');
        //Conceptos devengados
        Route::resource('earnings', EarningController::class);
        //Conceptos de deducciones
        Route::resource('deductions', DeductionController::class);
        //conceptos de nomina por empleado
        Route::resource('/payroll_details', PayrollDetailController::class);
        //----Actualizar dias trabajados
        Route::patch('/payroll_details/{payrollDetail}/update-days', [PayrollDetailController::class, 'updateDays'])->name('payroll_details.update_days');








});

require __DIR__.'/auth.php';
