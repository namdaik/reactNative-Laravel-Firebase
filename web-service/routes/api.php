<?php


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

Route::middleware(['jwt.auth', 'auth:api-employee', 'checkRole:admin', 'checkActive:api-employee'])
    ->prefix('admin/managerment')
    ->namespace('Admin\Manager')
    ->group(function () {
        Route::get('manager/show-transaction-points', 'ManagerController@showTransactionPoints');
        Route::post('manager', 'ManagerController@store');
        Route::put('manager/{id}', 'ManagerController@update');
        Route::get('managers', 'ManagerController@index');
        Route::get('manager/{id}', 'ManagerController@show');
    });

Route::middleware(['jwt.auth', 'auth:api-employee', 'checkRole:manager', 'checkActive:api-employee'])
    ->prefix('admin/managerment')
    ->namespace('Admin\Staff')
    ->group(function () {
        Route::post('staff', 'StaffManagerController@store');
        Route::put('staff/{id}', 'StaffManagerController@update');
        Route::get('staffs', 'StaffManagerController@index');
        Route::get('staff/{id}', 'StaffManagerController@show');
    });

Route::post('admin/login', 'Admin\Auth\LoginController@login');
Route::middleware(['jwt.auth', 'auth:api-employee'])
    ->namespace('Admin\Auth')
    ->group(function () {
        Route::get('auth/show/employee', 'AuthController@employee');
        Route::put('auth/employee/profile', 'ProfileController@updateProfileEmployee');
        Route::get('admin/logout', 'LogoutController@logout');
    });

Route::middleware(['jwt.auth', 'auth:api', 'checkActive:api'])
    ->prefix('user')
    ->namespace('User\Order')
    ->group(function () {
        Route::post('order', 'OrderController@store');
        Route::put('/order/{id}', 'OrderController@update');
        Route::get('orders/{option?}', 'OrderController@index');
        Route::get('order/show-top5-place-of-shipment', 'OrderController@showTop5PlaceOfShipment');
        Route::get('order/{id}', 'OrderController@show');
        Route::delete('order/{id}', 'OrderController@destroy');
    });

Route::middleware(['jwt.auth', 'auth:api-employee', 'checkRole:manager|receptionist', 'checkActive:api-employee'])
    ->prefix('admin/managerment')
    ->namespace('Admin\Order')
    ->group(function () {
        Route::post('order', 'OrderController@store');
        Route::put('/order/update', 'OrderController@update');
        Route::get('orders/{option?}', 'OrderController@index');
        Route::get('order/{id}', 'OrderController@show');
        Route::get('search-user', 'OrderController@searchUser');
        Route::get('search-order', 'OrderController@searchOrder');
    });

Route::middleware(['jwt.auth', 'auth:api-employee', 'checkRole:manager|receptionist', 'checkActive:api-employee'])
    ->prefix('admin/managerment')
    ->namespace('Admin\Package')
    ->group(function () {
        Route::post('package', 'PackageController@store');
        Route::post('package/create-package-send', 'PackageController@createPackageSend');
        Route::post('package/create-package-shipper-delivering', 'PackageController@createPackageShipperDelivering');
        Route::put('/package/update-package-shipper/{id}', 'PackageController@updatePackageForShipper');
        Route::put('/package/update-package-comming/{id}', 'PackageController@updatePackageComming');
        Route::get('/package/show-transaction-point-for-send', 'PackageController@showTransactionPointForSend');
        Route::get('/package/list-order-for-create-package', 'PackageController@listOrderForCreatePackage');
        Route::get('/package/list-shipper-for-create-package', 'PackageController@listShipperForCreatePackage');
        Route::get('packages/{option?}', 'PackageController@index');
        Route::get('package/{id}', 'PackageController@show');
    });

Route::middleware(['jwt.auth', 'auth:api-employee', 'checkRole:admin', 'checkActive:api-employee'])
    ->prefix('admin/managerment')
    ->namespace('Admin\TransactionPoint')
    ->group(function () {
        Route::get('transaction-points', 'TransactionPointController@index');
        Route::post('transaction-point/create', 'TransactionPointController@store');
        Route::get('transaction-point/{id}', 'TransactionPointController@show');
        Route::put('transaction-point/{id}', 'TransactionPointController@update');
    });

Route::middleware(['jwt.auth', 'auth:api-employee', 'checkRole:admin', 'checkActive:api-employee'])
    ->prefix('admin/managerment')
    ->namespace('Admin\User')
    ->group(function () {
        Route::get('users', 'UserController@index');
        Route::get('users/{id}', 'UserController@show');
        Route::put('users/{id}', 'UserController@update');
    });

Route::middleware(['jwt.auth', 'auth:api-employee', 'checkRole:admin', 'checkActive:api-employee'])
    ->prefix('admin/managerment')
    ->namespace('Admin\Dashboard')
    ->group(function () {
        Route::get('dashboard', 'DashboardController@index');
    });

Route::middleware(['jwt.auth', 'auth:api-employee', 'checkRole:manager', 'checkActive:api-employee'])
    ->prefix('admin/managerment')
    ->namespace('Admin\Dashboard')
    ->group(function () {
        Route::get('dashboard-manager', 'DashboardManagerController@index');
    });

Route::get('63-provinces', 'User\Order\OrderController@getProvincesAndDistrictsAndWards');
Route::post('user/login', 'User\Auth\LoginController@login');
Route::middleware(['jwt.auth', 'auth:api'])
    ->group(function () {
        Route::get('user/logout', 'User\Auth\LogoutController@logout');
        Route::put('auth/profile/user', 'User\Auth\ProfileController@updateProfileUser');
        Route::get('auth/show/user', 'User\Auth\AuthController@getInfo');
    });

Route::middleware(['jwt.auth', 'auth:api'])
    ->prefix('user')
    ->namespace('User\Dashboard')
    ->group(function () {
        Route::get('dashboard', 'DashboardController@index');
    });

Route::namespace('Guest\Order')
    ->group(function () {
        Route::get('search-order', 'OrderController@search');
    });

Route::middleware('session_api')
    ->namespace('User\Auth')
    ->group(function () {
        Route::post('user/send-otp', 'RegisterController@sendOtp');
        Route::post('user/verify-otp', 'RegisterController@verifyOtp');
        Route::post('user/register', 'RegisterController@register');
    });
