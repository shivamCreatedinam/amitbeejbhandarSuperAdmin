<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\LeadController;
use App\Http\Controllers\Admin\UserController;
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

Route::group(['prefix' => 'admin',  'middleware' => 'auth:web'], function () {

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

    Route::get("settings", [SettingController::class, "index"])->name("admin_setting");
    Route::post("settings-update", [SettingController::class, "settingUpdate"])->name("admin_setting_update");

    Route::get("logout", [AuthController::class, "logout"])->name("admin_logout");
});
