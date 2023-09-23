<?php

use Illuminate\Support\Facades\Route;
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
    return redirect()->route('sheets.create');
})->name('dashboard');


Route::resource('sheets', SheetController::class)
    ->only(['index', 'create', 'store', 'show', 'update']);

Route::post('/sheets/import', [SheetController::class, 'import'])->name('sheets.import');
Route::get('/sheets/export', [SheetController::class, 'export'])->name('sheets.export');