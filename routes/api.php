<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\EmailVerificationController;
use App\Http\Controllers\Api\NewPasswordController;
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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::middleware('auth:sanctum', 'verified')->get('/user', function( Request $request ) {
    return $request->user();
});


// Route::post('login', [])
Route::post('login', [AuthController::class, 'login']);
Route::post('register', [AuthController::class, 'register']);
Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

/**
 * 1.- http://127.0.0.1:8000/api/email/verification-notification
 *      -> se envia el correo de notificacion y recives http://127.0.0.1:8000/api/verify-email/4/4be5a1201077d10124962f66f2bc872d6a8cd771?expires=1624165394&signature=6cf770fcfb0653044cfa38e05156d6885a51511c3b9a994a5584f29b8ebbde2c
 *      ->agregas en los header Authorization Bearer token
 * 2.- Implementas la verificacion con la ruta http://127.0.0.1:8000/api/verify-email/{id}/{hash} que se recibio en el correo
 */

Route::post('email/verification-notification', [EmailVerificationController::class, 'sendVerificationEmail'])->middleware('auth:sanctum');
//! http://127.0.0.1:8000/api/verify-email/4/4be5a1201077d10124962f66f2bc872d6a8cd771?expires=1624165394&signature=6cf770fcfb0653044cfa38e05156d6885a51511c3b9a994a5584f29b8ebbde2c
// http://127.0.0.1:8000?email_verify_url=http://127.0.0.1:8000/api/verify-email/4/4be5a1201077d10124962f66f2bc872d6a8cd771?expires=1624165294&signature=3b3f0f0ceda9545126d6c64676fae5af5751dbd3e9ca22bd162d210759b70185
Route::get('verify-email/{id}/{hash}', [EmailVerificationController::class, 'verify'])->name('verification.verify')->middleware('auth:sanctum');


Route::post('forgot-password', [NewPasswordController::class, 'forgotPassword']);
Route::post('reset-password', [NewPasswordController::class, 'reset']);

