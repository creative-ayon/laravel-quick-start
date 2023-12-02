<?php

use App\Http\Controllers\Backend\DashboardController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');


    //temp for setting role and permission section in admin
    Route::get('admin/dashboard',[DashboardController::class,'index'])->name('admin.dashboard');



    Route::middleware(['permission'])->prefix('/admin')->group(function () {

        Route::get('/',[DashboardController::class,'index'])->name('admin.home'); //clone of dashboard

       // Route::get('/dashboard',[DashboardController::class,'index'])->name('admin.dashboard');

    });



});


