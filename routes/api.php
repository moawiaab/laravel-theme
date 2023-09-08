<?php


use Illuminate\Support\Facades\Route;

Route::group(['namespace' => 'Api', 'middleware' => ['auth:sanctum']], function () {
    Route::get('abilities', 'AbilitiesController@index');
    //! permission controller
    Route::resource('permissions', 'PermissionsApiController');
    Route::post('/permissions/delete-all', 'PermissionsApiController@destroyAll');
    Route::post('/permissions/add-all', 'PermissionsApiController@addAll');
    Route::put('/permissions/{item}/restore', 'PermissionsApiController@restore');
    Route::put('/permissions/{item}/delete-restore', 'PermissionsApiController@deleteRestore');
    Route::get('/permissions-export', 'PermissionsApiController@export');

    Route::get('/dashboard', 'DashboardApiController@index')->name('dashboard');
    // ! account controller
    Route::resource('accounts', 'AccountApiController');
    Route::put('/accounts/{account}/toggle', 'AccountApiController@toggle')->name('account.toggle');

    // ! Roles controller
    Route::resource('roles', 'RolesApiController');
    Route::post('/roles/delete-all', 'RolesApiController@destroyAll');
    Route::put('/roles/{item}/restore', 'RolesApiController@restore');

    //! Users controller
    Route::resource('/users', 'UsersApiController');
    Route::put('/users/{user}/toggle', 'UsersApiController@toggle')->name('user.toggle');
    Route::post('/users/delete-all', 'UsersApiController@destroyAll');
    Route::post('/users/add-all', 'UsersApiController@addAll');
    Route::put('/users/{item}/restore', 'UsersApiController@restore');
    Route::post('/users/password', 'UsersApiController@password')->name('users.password');
    Route::post('/users/media', 'UsersApiController@storeMedia')->name('users.storeMedia');
    Route::put('/users/{user}/locker', 'UsersApiController@locker');

    Route::get('/settings', 'SettingApiController@index');
    Route::post('/settings/data', 'SettingApiController@setData');

    Route::get('/shops/data', 'UsersApiController@showData');
    //! stages  controller
    Route::resource('stages', 'StageApiController');
    Route::put('/stages/{stage}/toggle', 'StageApiController@toggle');

    // ! expanses controller
    Route::resource('expanses', 'ExpanseApiController');
    Route::put('/expanses/{expanse}/toggle', 'ExpanseApiController@toggle');
    Route::put('/expanses/{expanse}/done', 'ExpanseApiController@done');

    //! public treasured controller
    Route::resource('public-treasuries', 'PublicTreasuryApiController');
    Route::get('public-treasuries/show-data/{id}', 'PublicTreasuryApiController@show');
    Route::put('public-treasuries/{item}/done', 'PublicTreasuryApiController@done');
    //! private locker controller
    Route::resource('private-lockers', 'PrivateLockerApiController');
    Route::put('/private-lockers/{privateLocker}/toggle', 'PrivateLockerApiController@toggle');
    Route::put('/private-lockers/{privateLocker}/amount', 'PrivateLockerApiController@amount');

    //! Budget Name controller
    Route::resource('budget-names', 'BudgetNameApiController');
    Route::put('/budget-names/{budgetName}/restore', 'BudgetNameApiController@restore');
    Route::put('/budget-names/{budgetName}/toggle', 'BudgetNameApiController@toggle');

    //! Budgets controller
    Route::resource('budgets', 'BudgetApiController');
    Route::put('/budgets/{budget}/restore', 'BudgetApiController@restore');
    Route::put('/budgets/{budget}/toggle', 'BudgetApiController@toggle');

    // Client controllers function
    Route::resource('clients', 'ClientApiController');
    // Route::post('/clients/delete-all', 'ClientApiController@destroyAll');
    // Route::post('/clients/add-all', 'ClientApiController@addAll');
    Route::put('/clients/{client}/restore', 'ClientApiController@restore');
    Route::put('/clients/{client}/toggle', 'ClientApiController@toggle');
    Route::put('/clients/{client}/amount', 'ClientApiController@amount');
    Route::get('/clients/{client}/amounts', 'ClientApiController@getAmount');

    // Supplier controllers function
    Route::resource('suppliers', 'SupplierApiController');
    // Route::post('/suppliers/delete-all', 'SupplierApiController@destroyAll');
    // Route::post('/suppliers/add-all', 'SupplierApiController@addAll');
    Route::put('/suppliers/{supplier}/restore', 'SupplierApiController@restore');
    Route::put('/suppliers/{supplier}/toggle', 'SupplierApiController@toggle');
    Route::put('/suppliers/{supplier}/amount', 'SupplierApiController@amount');
    Route::get('/suppliers/{supplier}/amounts', 'SupplierApiController@getAmount');

    Route::resource('units', 'UnitApiController');
    Route::resource('categories', 'CategoryApiController');
    // Route::post('/categories/delete-all', 'CategoryApiController@destroyAll');
    // Route::post('/categories/add-all', 'CategoryApiController@addAll');
    Route::put('/categories/{item}/restore', 'CategoryApiController@restore');

    Route::resource('products', 'ProductApiController');
    // Route::post('/products/delete-all', 'ProductApiController@destroyAll');
    // Route::post('/products/add-all', 'ProductApiController@addAll');
    Route::put('/products/{item}/restore', 'ProductApiController@restore');
    Route::post('/products/media', 'ProductApiController@storeMedia')->name('products.storeMedia');

    Route::resource('stores', 'StoreApiController');
    Route::put('/stores/{store}/toggle', 'StoreApiController@toggle');

    // suppliers order controller function
    Route::resource('supplier-orders', 'SupplierOrderApiController');
    Route::put('supplier-orders/{supplierOrder}/done', 'SupplierOrderApiController@done');

    // client order controller function
    Route::resource('orders', 'OrderApiController');
    Route::get('/order-backs', 'OrderApiController@getBack');
    Route::put('/orders/{item}/back', 'OrderApiController@back');
    Route::put('/orders/{back}/backDone', 'OrderApiController@backDone');
    Route::put('/orders/{item}/done', 'OrderApiController@done');
    Route::put('/orders/{order}/back-all', 'OrderApiController@backAll');

    //check
    Route::get('/checks','CheckApiController@index');
    Route::put('/checks/{item}/done', 'CheckApiController@done');

    //reports
    Route::get('/reports', 'ReportsApiController@index');
    Route::get('/reports-show', 'ReportsApiController@show');
});