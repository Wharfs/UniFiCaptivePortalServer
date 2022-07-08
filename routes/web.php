<?php

use App\Http\Controllers\HotspotController;
use Illuminate\Support\Facades\Route;

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

Route::controller(HotspotController::class)->group(function () {
    Route::get('/', 'index')->name('hotspot-index');
    Route::get('register', 'register')->name('hotspot-register');
    Route::post('store', 'store')->name('hotspot-store');
});
