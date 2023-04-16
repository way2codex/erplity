<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\UnitTypeController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\PurchaseOrderController;
use App\Http\Controllers\ProductCategoryController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\OrderPaymentController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\HomeController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('auth/login');
})->middleware('guest');

Route::get('optimize', function () {
    // Config::set('database.connections.mysql.database','db_ecommerce');
    Artisan::call('optimize:clear');
    return redirect('/');
});


Route::get('seed', function () {
    Artisan::call('db:seed');
    return redirect('/');
});

Auth::routes();

Route::get('/admin', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['prefix' => 'unit_type', 'middleware' => ['auth'],], function () {
    Route::get('/', [App\Http\Controllers\UnitTypeController::class, 'index'])->name('unit_type');
    Route::get('/get', [App\Http\Controllers\UnitTypeController::class, 'get'])->name('get_unit_type');
    Route::get('/create', [App\Http\Controllers\UnitTypeController::class, 'create'])->name('create_unit_type');
    Route::post('/store', [App\Http\Controllers\UnitTypeController::class, 'store'])->name('store_unit_type');
    Route::get('edit/{id}', [App\Http\Controllers\UnitTypeController::class, 'edit'])->name('edit_unit_type');
    Route::post('/update', [App\Http\Controllers\UnitTypeController::class, 'update'])->name('update_unit_type');
    Route::post('/delete', [App\Http\Controllers\UnitTypeController::class, 'delete'])->name('delete_unit_type');
    Route::get('/active/{id}', [UnitTypeController::class, 'changeStatus'])->name('active_unit_type');
    Route::get('/inactive/{id}', [UnitTypeController::class, 'changeStatus'])->name('inactive_unit_type');
});


Route::group(['prefix' => 'product_category', 'middleware' => ['auth'],], function () {
    Route::get('/', [ProductCategoryController::class, 'index'])->name('product_category');
    Route::get('/get', [ProductCategoryController::class, 'get'])->name('get_product_category');
    Route::get('/create', [ProductCategoryController::class, 'create'])->name('create_product_category');
    Route::post('/store', [ProductCategoryController::class, 'store'])->name('store_product_category');
    Route::get('edit/{id}', [ProductCategoryController::class, 'edit'])->name('edit_product_category');
    Route::post('/update', [ProductCategoryController::class, 'update'])->name('update_product_category');
    Route::post('/delete', [ProductCategoryController::class, 'delete'])->name('delete_product_category');
    Route::get('/active/{id}', [ProductCategoryController::class, 'changeStatus'])->name('active_product_category');
    Route::get('/inactive/{id}', [ProductCategoryController::class, 'changeStatus'])->name('inactive_product_category');
    Route::post('/checkName', [ProductCategoryController::class, 'checkName'])->name('product_category_check');
    Route::get('/getAjaxCategory', [ProductCategoryController::class, 'getAjaxCategory'])->name('get_ajax_category');
});


Route::group(['prefix' => 'product', 'middleware' => ['auth'],], function () {
    Route::get('/', [ProductController::class, 'index'])->name('product');
    Route::get('/get', [ProductController::class, 'get'])->name('get_product');
    Route::get('/create', [ProductController::class, 'create'])->name('create_product');
    Route::post('/store', [ProductController::class, 'store'])->name('store_product');
    Route::get('edit/{id}', [ProductController::class, 'edit'])->name('edit_product');
    Route::post('/update', [ProductController::class, 'update'])->name('update_product');
    Route::post('/delete', [ProductController::class, 'delete'])->name('delete_product');
    Route::get('/active/{id}', [ProductController::class, 'changeStatus'])->name('active_product');
    Route::get('/inactive/{id}', [ProductController::class, 'changeStatus'])->name('inactive_product');
    Route::post('/delete_product_image', [ProductController::class, 'delete_product_image'])->name('delete_product_image');
});

Route::group(['prefix' => 'order', 'middleware' => ['auth'],], function () {
    Route::get('/', [OrderController::class, 'index'])->name('order');
    Route::get('/get', [OrderController::class, 'get'])->name('get_order');
    Route::get('/create', [OrderController::class, 'create'])->name('create_order');
    Route::post('/store', [OrderController::class, 'store'])->name('store_order');
    Route::get('view/{id}', [OrderController::class, 'show'])->name('view_order');
    Route::post('/get_product_stock', [OrderController::class, 'get_product_stock'])->name('get_product_stock_order');
    Route::post('/order_payment_popup', [OrderController::class, 'order_payment_popup'])->name('order_payment_popup');
    Route::post('/order_payment_store', [OrderController::class, 'order_payment_store'])->name('order_payment_store');
    Route::get('/order_pdf/{id}', [OrderController::class, 'order_pdf'])->name('order_pdf');
    Route::post('/delete', [OrderController::class, 'delete'])->name('delete_order');
});

Route::group(['prefix' => 'supplier', 'middleware' => ['auth'],], function () {
    Route::get('/', [SupplierController::class, 'index'])->name('supplier');
    Route::get('/get', [SupplierController::class, 'get'])->name('get_supplier');
    Route::get('/create', [SupplierController::class, 'create'])->name('create_supplier');
    Route::post('/store', [SupplierController::class, 'store'])->name('store_supplier');
    Route::get('edit/{id}', [SupplierController::class, 'edit'])->name('edit_supplier');
    Route::post('/update', [SupplierController::class, 'update'])->name('update_supplier');
    Route::post('/delete', [SupplierController::class, 'delete'])->name('delete_supplier');
    Route::get('/active/{id}', [SupplierController::class, 'changeStatus'])->name('active_supplier');
    Route::get('/inactive/{id}', [SupplierController::class, 'changeStatus'])->name('inactive_supplier');
    Route::post('/checkMobile', [SupplierController::class, 'checkMobile'])->name('supplier_mobile_check');
    Route::get('/getAjaxSupplier', [SupplierController::class, 'getAjaxSupplier'])->name('get_ajax_supplier');
});


Route::group(['prefix' => 'customer', 'middleware' => ['auth'],], function () {
    Route::get('/', [CustomerController::class, 'index'])->name('customer');
    Route::get('/get', [CustomerController::class, 'get'])->name('get_customer');
    Route::get('/get_customer_order', [CustomerController::class, 'get_customer_order'])->name('get_customer_order');
    Route::get('/get_customer_payment', [CustomerController::class, 'get_customer_payment'])->name('get_customer_payment');
    Route::get('/create', [CustomerController::class, 'create'])->name('create_customer');
    Route::post('/store', [CustomerController::class, 'store'])->name('store_customer');
    Route::get('edit/{id}', [CustomerController::class, 'edit'])->name('edit_customer');
    Route::post('/update', [CustomerController::class, 'update'])->name('update_customer');
    Route::post('/delete', [CustomerController::class, 'delete'])->name('delete_customer');
    Route::get('/active/{id}', [CustomerController::class, 'changeStatus'])->name('active_customer');
    Route::get('/inactive/{id}', [CustomerController::class, 'changeStatus'])->name('inactive_customer');
    Route::post('/checkMobile', [CustomerController::class, 'checkMobile'])->name('customer_mobile_check');
    Route::get('view/{id}', [CustomerController::class, 'view'])->name('view_customer');
    Route::post('/order_detail_popup', [CustomerController::class, 'order_detail_popup'])->name('order_detail_popup');
    Route::post('/customer_payment_popup', [CustomerController::class, 'customer_payment_popup'])->name('customer_payment_popup');
    Route::post('/customer_payment_store', [CustomerController::class, 'customer_payment_store'])->name('customer_payment_store');
    Route::get('/getAjaxCustomer', [CustomerController::class, 'getAjaxCustomer'])->name('get_ajax_customer');
});

Route::group(['prefix' => 'setting', 'middleware' => ['auth'],], function () {
    Route::get('/', [SettingController::class, 'index'])->name('setting');
    Route::post('/update', [SettingController::class, 'update'])->name('update_setting');
});


Route::group(['prefix' => 'purchase_order', 'middleware' => ['auth'],], function () {
    Route::get('/', [PurchaseOrderController::class, 'index'])->name('purchase_order');
    Route::get('/get', [PurchaseOrderController::class, 'get'])->name('get_purchase_order');
    Route::get('/create', [PurchaseOrderController::class, 'create'])->name('create_purchase_order');
    Route::post('/store', [PurchaseOrderController::class, 'store'])->name('store_purchase_order');
    Route::get('edit/{id}', [PurchaseOrderController::class, 'edit'])->name('edit_purchase_order');
    Route::get('view/{id}', [PurchaseOrderController::class, 'show'])->name('view_purchase_order');
    Route::post('/update', [PurchaseOrderController::class, 'update'])->name('update_purchase_orderr');
    Route::post('/delete', [PurchaseOrderController::class, 'delete'])->name('delete_purchase_order');
    Route::post('/purchase_order_payment_popup', [PurchaseOrderController::class, 'purchase_order_payment_popup'])->name('purchase_order_payment_popup');
    Route::post('/purchase_order_payment_store', [PurchaseOrderController::class, 'purchase_order_payment_store'])->name('purchase_order_payment_store');
    Route::get('/active/{id}', [PurchaseOrderController::class, 'changeStatus'])->name('active_purchase_order');
    Route::get('/inactive/{id}', [PurchaseOrderController::class, 'changeStatus'])->name('inactive_purchase_order');
});

Route::group(['prefix' => 'passwordChange', 'middleware' => ['auth'],], function () {
    Route::get('/', [ResetPasswordController::class, 'index'])->name('passwordChange');
    Route::post('/update', [ResetPasswordController::class, 'update'])->name('passwordUpdate');
});

Route::group(['prefix' => 'expense', 'middleware' => ['auth'],], function () {
    Route::get('/', [ExpenseController::class, 'index'])->name('expense');
    Route::get('/get', [ExpenseController::class, 'get'])->name('get_expense');
    Route::get('/create', [ExpenseController::class, 'create'])->name('create_expense');
    Route::post('/store', [ExpenseController::class, 'store'])->name('store_expense');
    Route::get('edit/{id}', [ExpenseController::class, 'edit'])->name('edit_expense');
    Route::post('/update', [ExpenseController::class, 'update'])->name('update_expense');
    Route::post('/delete', [ExpenseController::class, 'delete'])->name('delete_expense');
    Route::post('/pdf', [ExpenseController::class, 'expense_pdf'])->name('expense_pdf');
});

Route::group(['prefix' => 'profile', 'middleware' => ['auth'],], function () {
    Route::get('/', [UserController::class, 'index'])->name('profile');
    Route::post('/update', [UserController::class, 'update'])->name('update_profile');
});

Route::group(['prefix' => 'order_payments', 'middleware' => ['auth'],], function () {
    Route::get('/', [OrderPaymentController::class, 'index'])->name('order_payments');
    Route::get('/get_order_payments', [OrderPaymentController::class, 'get'])->name('get_order_payments');
});
Route::get('pdf_demo', [HomeController::class, 'pdf_demo']);
