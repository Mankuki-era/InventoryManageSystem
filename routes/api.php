<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\UsersController;
use App\Http\Controllers\API\ItemController;
use App\Http\Controllers\API\CartsController;
use App\Http\Controllers\API\ThemasController;
use App\Http\Controllers\API\TagsController;
use App\Http\Controllers\API\NotificationsController;
use App\Http\Controllers\API\InformationsController;
use App\Http\Controllers\API\HistoryController;
use App\Models\Information;
use App\Models\Notification;
use App\Models\Item;
use App\Models\User;
use App\Models\Tag;
use App\Models\Thema;
use App\Http\Controllers\ImportExcelController;
// use App\Http\Controllers\ExportExcelController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/



//ログインしていた場合の処理
Route::get('info',  [InformationsController::class, 'getinfo']);
Route::get('checkAdmin',  [InformationsController::class, 'checkAdmin']);
Route::get('/countInfo', [InformationsController::class, 'countinfo']);
Route::get('/grade', [ThemasController::class, 'grade']);
Route::get('/themas', [ThemasController::class, 'thema']);
Route::get('/cart', [CartsController::class, 'store']);
Route::get('/uncart', [CartsController::class, 'delete']);
Route::get('/favorite', [ItemController::class, 'favorite']);
Route::get('/unfavorite', [ItemController::class, 'unfavorite']);
Route::get('/cartinfo', [CartsController::class, 'cartinfo']);
Route::get('/carts', [CartsController::class, 'index']);
Route::get('/themaCategory', [ThemasController::class, 'categoryList']);
// Route::get('/carts/export_view', [ExportExcelController::class, 'export_view']);

Route::post('/register', [UsersController::class, 'register']);
Route::post('/login', [UsersController::class, 'login']);
Route::post('/resetInfo', [InformationsController::class, 'resetinfo']);
Route::post('/allResetinfo', [InformationsController::class, 'allResetinfo']);
Route::post('/logout', [UsersController::class, 'logout']);
Route::post('/admin/item', [ItemController::class, 'admincreate']);
Route::post('/infoUpdate', [InformationsController::class, 'updateinfo']);
Route::post('/refreshItem', [ItemController::class, 'refresh']);
Route::post('/refreshNotification', [NotificationsController::class, 'refresh']);
Route::post('/refreshHistory', [HistoryController::class, 'refresh']);
Route::post('/refreshCart', [CartsController::class, 'refresh']);
Route::post('/import', [ImportExcelController::class, 'import']);

Route::put('item/stocks/{item}',[ItemController::class, 'stocksUpdate']);

Route::apiResource('item', ItemController::class);
Route::apiResource('cart', CartsController::class)->only(['update', 'destroy']);
Route::apiResource('user', UsersController::class);
Route::apiResource('thema', ThemasController::class);
Route::apiResource('tag', TagsController::class)->only(['index']);
Route::apiResource('notification', NotificationsController::class);
Route::apiResource('history', HistoryController::class);