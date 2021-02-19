<?php

use App\Http\Controllers\CityController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\DepartmentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\StateController;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// employees
Route::get('/employees', [EmployeeController::class, 'index']);
Route::prefix('/employee')->group(
    function() {
        Route::post('/store', [EmployeeController::class, 'store']);
        Route::put('/{id}', [EmployeeController::class, 'update']);
        Route::delete('/{id}', [EmployeeController::class, 'destroy']);
    }
);

// departments
Route::get('/departments', [DepartmentController::class, 'index']);
Route::prefix('/department')->group(
    function() {
        Route::post('/store', [DepartmentController::class, 'store']);
        Route::put('/{id}', [DepartmentController::class, 'update']);
        Route::delete('/{id}', [DepartmentController::class, 'destroy']);
    }
);

// countries
Route::get('/countries', [CountryController::class, 'index']);
Route::prefix('/country')->group(
    function() {
        Route::post('/store', [CountryController::class, 'store']);
        Route::put('/{id}', [CountryController::class, 'update']);
        Route::delete('/{id}', [CountryController::class, 'destroy']);
    }
);

// states
Route::get('/states', [StateController::class, 'index']);
Route::prefix('/state')->group(
    function() {
        Route::get('/by-country/{countryId}', [StateController::class, 'getAllByCountryId']);
        Route::post('/store', [StateController::class, 'store']);
        Route::put('/{id}', [StateController::class, 'update']);
        Route::delete('/{id}', [StateController::class, 'destroy']);
    }
);

// cities
Route::get('/cities', [CityController::class, 'index']);
Route::prefix('/city')->group(
    function() {
        Route::get('/by-state/{stateId}', [CityController::class, 'getAllByStateId']);
        Route::post('/store', [CityController::class, 'store']);
        Route::put('/{id}', [CityController::class, 'update']);
        Route::delete('/{id}', [CityController::class, 'destroy']);
    }
);