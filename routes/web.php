<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\LeadController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\SubCategoryController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ProductVariantController;
use App\Http\Controllers\SettingController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get("/", [AuthController::class, "loginView"])->name("login");
Route::post("login", [AuthController::class, "loginPost"])->name("loginPost");

Route::get("header", [HomeController::class, "printHeaders"]);

Route::group(['middleware' => 'auth:web'], function () {

    Route::get('/dashboard', [HomeController::class, "dashboard"])->name("dashboard");

    Route::group(['prefix' => 'user'], function () {
        Route::get('/user-list', [UserController::class, "userList"])->name("admin_user_list");
        Route::get('/user-view/{user_id}', [UserController::class, "userView"])->name("admin_user_view");
        Route::get('/user-edit/{user_id}', [UserController::class, "userEdit"])->name("admin_user_edit");
        Route::post('/user-update', [UserController::class, "userUpdate"])->name("admin_user_update");
        Route::post('/user-status-update', [UserController::class, "userStatusUpdate"])->name("admin_user_status_update");
    });

    Route::group(['prefix' => 'lead'], function () {
        Route::get('/lead-list', [LeadController::class, "index"])->name("admin_lead_list");
        Route::get('/quotes-list/{id}', [LeadController::class, "quotesList"])->name("admin_quotes_list");
        Route::post('/send-mail', [LeadController::class, "sendMail"])->name("admin_mail_send");
        Route::post('/get-order-data', [LeadController::class, "getOrder"])->name("admin_get_order");
        Route::post('/change-order-status', [LeadController::class, "changeOrderStatus"])->name("admin_change_order_status");
        Route::get('/delete-lead/{id}', [LeadController::class, "deleteLead"])->name("admin_delete_lead");
    });

    Route::group(['prefix' => 'category'], function () {
        Route::get('/category-list', [CategoryController::class, "index"])->name("admin_category_list");
        Route::get('/category-delete/{id}', [CategoryController::class, "delete"])->name("admin_category_delete");
        Route::get('/add-category', [CategoryController::class, "addForm"])->name("admin_category_addform");
        Route::post('/add-category', [CategoryController::class, "store"])->name("admin_category_store");

    });

    Route::group(['prefix' => 'sub-category'], function () {
        Route::get('/list', [SubCategoryController::class, "index"])->name("admin_sub_category_list");
        Route::get('/delete/{id}', [SubCategoryController::class, "delete"])->name("admin_sub_category_delete");
        Route::get('/add', [SubCategoryController::class, "addForm"])->name("admin_sub_category_addform");
        Route::post('/store-sub-category', [SubCategoryController::class, "store"])->name("admin_sub_category_store");

    });


    Route::group(['prefix' => 'product'], function () {
        Route::get('/list', [ProductController::class, "index"])->name("admin_product_list");
        Route::get('/delete/{id}', [ProductController::class, "delete"])->name("admin_product_delete");
        Route::get('/add', [ProductController::class, "addForm"])->name("admin_product_addform");
        Route::get('/get-sub-cat/{cat_id}', [ProductController::class, "getSubCat"]);
        Route::post('/store-sub-category', [ProductController::class, "store"])->name("admin_product_store");
        Route::get('/edit/{id}', [ProductController::class, "edit"])->name('admin_product_edit');
        Route::post('/update/{id}', [ProductController::class, "update"])->name('admin_product_update');

    });

    Route::group(['prefix' => 'variant'], function () {
        // Display list of variants for a specific product
        Route::get('/list/{id}', [ProductVariantController::class, 'index'])->name('product_variant_list');
        Route::get('/add/{id}', [ProductVariantController::class, 'addForm'])->name('variant_addForm');
        Route::post('/store/{id}', [ProductVariantController::class, 'store'])->name('variant_store');
        Route::get('/edit/{id}', [ProductVariantController::class, 'editForm'])->name('variant_editForm');
        Route::post('/update/{id}', [ProductVariantController::class, 'update'])->name('variant_update');   
        Route::get('/delete/{id}', [ProductVariantController::class, 'destroy'])->name('variant_delete');
    });
    


    Route::group(['prefix' => 'brand'], function () {
        Route::get('/brand-list', [BrandController::class, "index"])->name("admin_brand_list");
        Route::get('/brand-delete/{id}', [BrandController::class, "delete"])->name("admin_brand_delete");
        Route::get('/add-brand', [BrandController::class, "addForm"])->name("admin_brand_addform");
        Route::post('/add-brand', [BrandController::class, "store"])->name("admin_brand_store");

    });

    Route::get("settings", [SettingController::class, "index"])->name("admin_setting");
    Route::post("settings-update", [SettingController::class, "settingUpdate"])->name("admin_setting_update");

    Route::get("logout", [AuthController::class, "logout"])->name("admin_logout");
});
