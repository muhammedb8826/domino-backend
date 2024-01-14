<?php

use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\Users\RoleController;
use App\Http\Controllers\Users\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::prefix('v1')->group(
    function () {
        Route::post('/login', [AuthenticationController::class, 'login'])->name('login');
    }
);

Route::middleware('auth:sanctum')->group(function (){
    Route::prefix('v1')->group(
        function () {
            Route::get('/logout', [AuthenticationController::class, 'logout']);
            Route::get('/getUser', [AuthenticationController::class, 'getCurrentUser']);
            Route::post('users/{user}/roles', [UserController::class,'assignRole']);
            Route::apiResource('users', UserController::class);
            Route::get('roles/generate-permissions', [RoleController::class, 'generatePermissions']);
            Route::apiResource('roles', RoleController::class);
        });

});
