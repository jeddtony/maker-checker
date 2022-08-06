<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PendingRequestController;
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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::group(['prefix' => 'v1'], function () {

    Route::post('/register', [AuthController::class, 'register']);

    Route::post('/login', [AuthController::class, 'login']);

    Route::get('/login', function () {
        return response()->json('Invalid auth', 401);
    })->name('login');

    Route::group(['middleware' => 'auth:sanctum'], function () {
        Route::get('/user', function (Request $request) {
            return $request->user();
        });

        Route::get('/logout', [AuthController::class, 'logout']);

        Route::group(['prefix' => 'pending-request'], function(){
            Route::get('/', [PendingRequestController::class, 'index']);
            Route::post('/', [PendingRequestController::class, 'store']);
            Route::get('/{uuid}', [PendingRequestController::class, 'show']);
            Route::put('/{uuid}', [PendingRequestController::class, 'update']);
            Route::delete('/{uuid}', [PendingRequestController::class, 'destroy']);
       
            Route::patch('/{uuid}/action', [PendingRequestController::class, 'actionAnAdminRequest']);
        });
    });
});
