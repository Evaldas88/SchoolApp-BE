<?php
use App\Http\Controllers\SchoolsController;
use App\Http\Controllers\ApplicationsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PassportAuthController;


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

Route::post('register', [PassportAuthController::class, 'register']);
Route::post('login', [PassportAuthController::class, 'login']);
Route::post('logout', [PassportAuthController::class, 'logout'])->middleware('auth:api');
Route::get('authcheck', [PassportAuthController::class, 'index'])->middleware('auth:api');

Route::get('schools', [SchoolsController::class, 'index']);
Route::get('schools/{id}', [SchoolsController::class, 'show']);
Route::post('schools', [SchoolsController::class, 'store'])->middleware('auth:api');
Route::post('schools/{id}', [SchoolsController::class, 'update'])->middleware('auth:api');
Route::delete('schools/{id}', [SchoolsController::class, 'destroy'])->middleware('auth:api');

Route::get('applications', [ApplicationsController::class, 'index'])->middleware('auth:api');
Route::get('applications/all', [ApplicationsController::class, 'all'])->middleware('auth:api');
Route::get('applications/{id}', [ApplicationsController::class, 'status'])->middleware('auth:api');
Route::post('applications', [ApplicationsController::class, 'store'])->middleware('auth:api');
Route::post('student/register', [ApplicationsController::class, 'store'])->middleware('auth:api');
Route::delete('applications/{id}', [ApplicationsController::class, 'destroy'])->middleware('auth:api');