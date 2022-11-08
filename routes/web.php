<?php

use Illuminate\Support\Facades\Route;

// Login
use App\Http\Livewire\Login\LoginForm;
use App\Http\Livewire\Login\Logout;

// Dashboard
use App\Http\Livewire\Dashboard\AdminDashboard;
use App\Http\Livewire\Dashboard\Settings;
use App\Http\Livewire\Dashboard\Security;
use App\Http\Livewire\Dashboard\Supervisor;
use App\Http\Livewire\Dashboard\Client;
use App\Http\Livewire\Dashboard\Attendance;
use App\Http\Livewire\Dashboard\Notification;

use App\Http\Livewire\Dashboard\Payslip;
// use App\Http\Livewire\Dashboard\Reports;

use App\Http\Livewire\Reports\Reports;
use App\Http\Livewire\Dashboard\Fieldtracking;
use App\Http\Livewire\Dashboard\Contactus;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function(){
    return view('welcome');
});

Route::get('admin-login', LoginForm::class)->name('login');
Route::get('/privacy-policy', function(){
    return view('layouts.content.customer.privacy-policy');
});
Route::middleware('authToken')->group(function(){

    Route::get('welcome', AdminDashboard::class)->name('welcome');
    Route::get('securities', Security::class)->name('securities');
    Route::get('supervisor', Supervisor::class)->name('supervisor');
    Route::get('client', Client::class)->name('client');
    Route::get('attendance', Attendance::class)->name('attendance');
    Route::get('notification', Notification::class)->name('notification');
    Route::get('fieldtracking', Fieldtracking::class)->name('fieldtracking');
    Route::get('payslip', Payslip::class)->name('payslip');
	Route::get('reports', Reports::class)->name('reports');
    Route::get('settings', Settings::class)->name('settings');
    Route::get('logout', [Logout::class, 'getLogin']);
    Route::get('others', Contactus::class)->name('others');
    Route::get('logout', [Logout::class, 'getLogin']);

});

// Route::group([ 'as' => 'reports.'], function () {
//     Route::get('reports', Reports::class)->name('reports');
//     Route::get('/filter/{for}/{f_date}/{t_date}', Reports::class)->name('filter');
// });
