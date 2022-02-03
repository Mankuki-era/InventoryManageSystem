<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ExportExcelController;
use App\Http\Controllers\ImportExcelController;

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

Route::get('/items/{any}', function () {
    return view('layouts.app');
})->where('any', '.*');

Route::get('carts/export_view', [ExportExcelController::class,'export_view'])->name('carts.export_view');
Route::get('backup/export_view', [ExportExcelController::class,'items_export_view'])->name('backup.export_view');
Route::post('import', [ImportExcelController::class, 'import']);

