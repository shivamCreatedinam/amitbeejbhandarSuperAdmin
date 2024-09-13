<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\BrandController;
use App\Http\Controllers\API\CategoryController;
use App\Http\Controllers\API\LeadController;
use App\Http\Controllers\API\PincodeController;
use App\Http\Controllers\API\ProductController;
use App\Http\Controllers\API\SubCategoryController;
use App\Http\Controllers\API\UserController;
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

Route::group(['prefix' => 'v1'], function () {

    Route::post("create-lead", [LeadController::class, "saveLeadData"]);
    Route::get("category-list", [CategoryController::class, "getCategory"]);
    Route::get("sub-category-list/{category_id}", [SubCategoryController::class, "getSubCategory"]);
    Route::get("brand-list", [BrandController::class, "getBrand"]);
    Route::post("products", [ProductController::class, "getProduct"]);

});
