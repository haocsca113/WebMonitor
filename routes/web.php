<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UptimeCheckController;
use App\Http\Controllers\AttackDetectedController;
use App\Http\Controllers\WebsiteController;

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/website-home', [WebsiteController::class, 'website_home'])->name('website-home');
Route::get('/website-home/add-url', [WebsiteController::class, 'add_url'])->name('add-url');
Route::post('/website-home/add-url/add-url-store', [WebsiteController::class, 'add_url_store'])->name('add-url-store');
Route::get('/website-home/view-url/{id}', [WebsiteController::class, 'view_url'])->name('view-url');
Route::get('/website-home/edit-url/{id}', [WebsiteController::class, 'edit_url'])->name('edit-url');
Route::patch('/website-home/edit-url/update-url/{id}', [WebsiteController::class, 'update_url'])->name('update-url');
Route::delete('/website-home/delete-url/{id}', [WebsiteController::class, 'delete_url'])->name('delete-url');


Route::get('/uptime-check', [UptimeCheckController::class, 'uptime_check'])->name('uptime-check');
Route::get('/uptime-check/check-url', [UptimeCheckController::class, 'check_url'])->name('check-url');
Route::post('/uptime-check/check-url/check-up-time', [UptimeCheckController::class, 'check_up_time'])->name('check-up-time');


Route::get('/attack-detected-home', [AttackDetectedController::class, 'attack_detected_home'])->name('attack-detected-home');
Route::get('/attack-detected-home/check-url-attack-detected', [AttackDetectedController::class, 'check_url_attack_detected'])->name('check-url-attack-detected');

Route::post('/attack-detected-home/check-url-attack-detected/attack-detected', [AttackDetectedController::class, 'attack_detected'])->name('attack-detected');

