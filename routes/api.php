<?php


use Illuminate\Support\Facades\Route;

Route::group(['namespace' => 'Moawiaab\LaravelTheme\Http\Controllers\Api', 'middleware' => ['auth:sanctum']], function () {
    // Client controllers function
    Route::resource('clients', 'ClientApiController');
    Route::put('/clients/{client}/restore', 'ClientApiController@restore');
    Route::put('/clients/{client}/toggle', 'ClientApiController@toggle');
    Route::put('/clients/{client}/amount', 'ClientApiController@amount');
    Route::get('/clients/{client}/amounts', 'ClientApiController@getAmount');

    Route::get('abilities', 'AbilitiesController@index');
    //! permission controller
    Route::resource('permissions', 'PermissionsApiController');
    Route::put('/permissions/{item}/restore', 'PermissionsApiController@restore');
    Route::put('/permissions/{item}/delete-restore', 'PermissionsApiController@deleteRestore');

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
    //expanse Route::resource('expanses', 'ExpanseApiController');
    //expanse Route::put('/expanses/{expanse}/toggle', 'ExpanseApiController@toggle');
    //expanse Route::put('/expanses/{expanse}/done', 'ExpanseApiController@done');

    //! public treasured controller
    Route::resource('public-treasuries', 'PublicTreasuryApiController');
    Route::get('public-treasuries/show-data/{id}', 'PublicTreasuryApiController@show');
    Route::put('public-treasuries/{item}/done', 'PublicTreasuryApiController@done');
    //! private locker controller
    Route::resource('private-lockers', 'PrivateLockerApiController');
    Route::put('/private-lockers/{privateLocker}/toggle', 'PrivateLockerApiController@toggle');
    Route::put('/private-lockers/{privateLocker}/amount', 'PrivateLockerApiController@amount');

    //! Budget Name controller
    //expanse Route::resource('budget-names', 'BudgetNameApiController');
    //expanse Route::put('/budget-names/{budgetName}/restore', 'BudgetNameApiController@restore');
    //expanse Route::put('/budget-names/{budgetName}/toggle', 'BudgetNameApiController@toggle');

    //expanse //! Budgets controller
    //expanse Route::resource('budgets', 'BudgetApiController');
    //expanse Route::put('/budgets/{budget}/restore', 'BudgetApiController@restore');
    //expanse Route::put('/budgets/{budget}/toggle', 'BudgetApiController@toggle');



    // Supplier controllers function
    //supplier Route::resource('suppliers', 'SupplierApiController');
    //supplier // Route::post('/suppliers/delete-all', 'SupplierApiController@destroyAll');
    //supplier // Route::post('/suppliers/add-all', 'SupplierApiController@addAll');
    //supplier Route::put('/suppliers/{supplier}/restore', 'SupplierApiController@restore');
    //supplier Route::put('/suppliers/{supplier}/toggle', 'SupplierApiController@toggle');
    //supplier Route::put('/suppliers/{supplier}/amount', 'SupplierApiController@amount');
    //supplier Route::get('/suppliers/{supplier}/amounts', 'SupplierApiController@getAmount');

    //product Route::resource('units', 'UnitApiController');
    //product Route::resource('categories', 'CategoryApiController');
    //product // Route::post('/categories/delete-all', 'CategoryApiController@destroyAll');
    //product // Route::post('/categories/add-all', 'CategoryApiController@addAll');
    //product Route::put('/categories/{item}/restore', 'CategoryApiController@restore');

    //product Route::resource('products', 'ProductApiController');
    //product // Route::post('/products/delete-all', 'ProductApiController@destroyAll');
    //product // Route::post('/products/add-all', 'ProductApiController@addAll');
    //product Route::put('/products/{item}/restore', 'ProductApiController@restore');
    //product Route::post('/products/media', 'ProductApiController@storeMedia')->name('products.storeMedia');

    //product Route::resource('stores', 'StoreApiController');
    //product Route::put('/stores/{store}/toggle', 'StoreApiController@toggle');

    //product // suppliers order controller function
    //product Route::resource('supplier-orders', 'SupplierOrderApiController');
    //product Route::put('supplier-orders/{supplierOrder}/done', 'SupplierOrderApiController@done');

    //product // client order controller function
    //product Route::resource('orders', 'OrderApiController');
    //product Route::get('/order-backs', 'OrderApiController@getBack');
    //product Route::put('/orders/{item}/back', 'OrderApiController@back');
    //product Route::put('/orders/{back}/backDone', 'OrderApiController@backDone');
    //product Route::put('/orders/{item}/done', 'OrderApiController@done');
    //product Route::put('/orders/{order}/back-all', 'OrderApiController@backAll');

    //check
    Route::get('/checks', 'CheckApiController@index');
    Route::put('/checks/{item}/done', 'CheckApiController@done');

    //reports
    Route::get('/reports', 'ReportsApiController@index');
    Route::get('/reports-show', 'ReportsApiController@show');
});
Route::group(['namespace' => 'App\Http\Controllers\Api', 'middleware' => ['auth:sanctum']], function () {
    //don't remove this
});
