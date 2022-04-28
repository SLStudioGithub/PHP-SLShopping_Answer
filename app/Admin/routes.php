<?php

use Illuminate\Routing\Router;

Admin::routes();

/**
 * 管理画面側のルーティンググループ
 *
 * ※prefix→どのルーティングでも/adminからスタートする
 * ※namespace→Controllerはapp/Admin/Controllers配下
 * ※middleware→どのルーティングもwebで定義されてるmiddlewareを通る
 * ※as→どのルーティングのnameもadmin.からスタートする
 */
Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
    'as'            => config('admin.route.prefix') . '.',
], function (Router $router) {

    // ダッシュボード画面
    $router->get('/dashboard', function () {
        return view('admin.dashboard.main');
    })->name('home');

    /**
     * 管理者系のルーティンググループ
     *
     * ※prefix→どのルーティングでも/admin/admin-usersからスタートする
     * ※as→どのルーティングのnameもadmin.adminUsers.からスタートする
     */
    $router->group([
        'prefix' => 'admin-users',
        'as' => 'adminUsers.',
    ], function (Router $router) {

        // 管理者一覧画面
        $router->get('/', 'AdminUsersController@index')->name('index');

        // 管理者新規作成画面
        $router->get('/create', 'AdminUsersController@showCreate')->name('createView');

        // 管理者新規作成
        $router->post('/create', 'AdminUsersController@create')->name('create');

        // 管理者詳細画面
        $router->get('/{id}', 'AdminUsersController@detail')->name('detail');

        // 管理者詳細画面
        $router->get('/edit/{id}', 'AdminUsersController@showEdit')->name('editView');

        // 管理者編集
        $router->post('/edit/{id}', 'AdminUsersController@edit')->name('edit');

        // 管理者削除
        $router->delete('/delete/{id}', 'AdminUsersController@delete')->name('delete');
    });

    /**
     * 利用ユーザー系のルーティンググループ
     *
     * ※prefix→どのルーティングでも/admin/usersからスタートする
     * ※as→どのルーティングのnameもadmin.users.からスタートする
     */
    $router->group([
        'prefix' => 'users',
        'as' => 'users.',
    ], function (Router $router) {

        // 利用ユーザー一覧画面
        $router->get('/', 'UsersController@index')->name('index');

        // 利用ユーザー詳細画面
        $router->get('/{id}', 'UsersController@detail')->name('detail');

        // 利用者購入履歴画面
        $router->get('/{id}/orders', 'UsersController@orders')->name('orders');
    });

    /**
     * 商品系のルーティンググループ
     *
     * ※prefix→どのルーティングでも/admin/itemsからスタートする
     * ※as→どのルーティングのnameもadmin.items.からスタートする
     */
    $router->group([
        'prefix' => 'items',
        'as' => 'items.',
    ], function (Router $router) {

        // 商品一覧画面
        $router->get('/', 'ItemsController@index')->name('index');

        // 商品新規作成画面
        $router->get('/create', 'ItemsController@showCreate')->name('createView');

        // 商品新規登録
        $router->post('/create', 'ItemsController@create')->name('create');

        // 商品詳細画面
        $router->get('/{id}', 'ItemsController@detail')->where('id', '[0-9]+')->name('detail');

        // 商品編集画面
        $router->get('/edit/{id}', 'ItemsController@showEdit')->name('editView');

        // 商品編集
        $router->post('/edit/{id}', 'ItemsController@edit')->name('edit');

        // 商品削除
        $router->delete('/delete/{id}', 'ItemsController@delete')->name('delete');

        // 商品在庫数量一覧画面
        $router->get('/stock', 'ItemsController@stockIndex')->name('stock');

        // 商品在庫数量編集画面
        $router->get('/{id}/stock/edit', 'ItemsController@showStockEdit')
            ->where('id', '[0-9]+')
            ->name('stockEditView');

        // 商品在庫数編集
        $router->post('/{id}/stock/edit', 'ItemsController@stockEdit')
            ->where('id', '[0-9]+')
            ->name('stockEdit');
    });

    /**
     * ブランド系のルーティンググループ
     *
     * ※prefix→どのルーティングでも/admin/brandsからスタートする
     * ※as→どのルーティングのnameもadmin.brands.からスタートする
     */
    $router->group([
        'prefix' => 'brands',
        'as' => 'brands.',
    ], function (Router $router) {

        // ブランド一覧画面
        $router->get('/', 'BrandsController@index')->name('index');

        // ブランド詳細画面
        $router->get('/{id}', 'BrandsController@detail')->where('id', '[0-9]+')->name('detail');

        // ブランド新規登録画面
        $router->get('/create', function () {
            return view('admin.brands.create');
        })->name('createView');

        // ブランド新規登録
        $router->post('/create', 'BrandsController@create')->name('create');

        // ブランド編集画面
        $router->get('/edit/{id}', 'BrandsController@showEdit')->where('id', '[0-9]+')->name('editView');

        // ブランド編集
        $router->post('/edit/{id}', 'BrandsController@edit')->where('id', '[0-9]+')->name('edit');

        // ブランド削除
        $router->delete('/delete/{id}', 'BrandsController@delete')->name('delete');
    });
});
