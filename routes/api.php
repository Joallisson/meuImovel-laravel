<?php

use App\Http\Controllers\Api\Auth\LoginJwtController;
use App\Http\Controllers\Api\RealStateController;
use App\Http\Controllers\Api\RealStatePhotoController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\CategoryController;
use App\Models\RealStatePhoto;
use Illuminate\Http\Request;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('v1')->group(function(){

    Route::post('login', [LoginJwtController::class, 'login'])->name('login');

    Route::group(['middleware' => 'jwt.auth'], function(){ //Rotas protegidas pelo middleware jwt

        Route::name('real-states.')->group(function(){

            Route::resource('real-states', RealStateController::class);
        });

        Route::name('users.')->group(function(){

            Route::resource('users', UserController::class);
        });

        Route::name('categories.')->group(function(){

            Route::get('categories/{id}/states', [CategoryController::class, 'realStates']);
            Route::resource('categories', CategoryController::class);
        });

        Route::name('photos.')->prefix('photos')->group(function(){

            Route::put('/set-thumb/{photoId}/{realStateId}', [RealStatePhotoController::class, 'setThumb'])->name('atualizar');
            Route::delete('/{id}', [RealStatePhotoController::class, 'remove'])->name('delete');
        });

    });

});
