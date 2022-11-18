<?php

use App\Http\Controllers\v1\api\JournalController;
use App\Http\Controllers\v1\api\QuoteController;
use Illuminate\Support\Facades\Route;

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

Route::prefix('journal')->group(function () {
    Route::get('/{slug}', [JournalController::class, 'show']);
    Route::get('/', [JournalController::class, 'index']);
    route::post('/', [journalcontroller::class, 'store']);
    route::put('/{entry}', [journalcontroller::class, 'update']);
});

Route::prefix('quote')->group(function () {
    Route::get('/', [QuoteController::class, 'show']);
    Route::post('/', [QuoteController::class, 'store']);
});
