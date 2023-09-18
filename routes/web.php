<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\SheetController;
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
    return redirect()->route('sheets.index');
})->name('dashboard');


Route::resource('sheets', SheetController::class)
    ->only(['index', 'create', 'store', 'show', 'update']);

Route::post('/store-data-in-session', [SessionController::class, 'storeDataInSession']);
Route::delete('/delete-data-from-session', [SessionController::class, 'deleteSessionData']);