<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

use App\Http\Controllers\RoleController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\EmployeeCompanyController;

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

});

require __DIR__.'/auth.php';
