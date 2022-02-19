<?php

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
use App\Http\Controllers\CmsController;

Route::get('/', [CmsController::class, 'cms']);
Route::get('/howto', [CmsController::class, 'howTo']);
Route::get('/config', [CmsController::class, 'config']);
Route::get('/config/getPage', [CmsController::class, 'GetPage'])->middleware('auth');
Route::post('/config/addPage', [CmsController::class, 'AddPage'])->middleware('auth');
Route::post('/config/delPage', [CmsController::class, 'DelPage'])->middleware('auth');
Route::get('/config/getComponent', [CmsController::class, 'GetComponent'])->middleware('auth');
Route::post('/config/addComponent', [CmsController::class, 'AddComponent'])->middleware('auth');
Route::post('/config/delComponent', [CmsController::class, 'DelComponent'])->middleware('auth');
Route::post('/config/upComponent', [CmsController::class, 'UpComponent'])->middleware('auth');
Route::get('/preview/{page?}', [CmsController::class, 'preview'])->middleware('auth');
Route::post('/message', [CmsController::class, 'sendMessage'])->middleware('auth');
