<?php

use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;

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

/**
 * Shop側のルーティンググループ
 *
 * ※prefix→どのルーティングでも/shopからスタートする
 * ※as→どのルーティングのnameもshop.からスタートする
 */
Route::group([
    'prefix' => 'shop',
    'as' => 'shop.',
], function (Router $router) {
    /**
     * shopのメインのルーティンググループ
     *
     * ※namespace→ControllerはApp/Http/Controllers/Shop配下
     */
    $router->group([
        'namespace' => 'Shop',
    ], function (Router $router) {
        // Top画面表示
        $router->get('/top', 'ShopTopController@top')->name('top');
        // Top画面商品検索
        $router->get('/search', 'ShopTopController@search')->name('search');
        // 商品詳細画面表示
        $router->get('/item-detail/{item}', 'ShopTopController@itemDetail')->name('item_detail');
        // 特定商取引に関する法律に基づく表記表示
        $router->get('/commercial-transactions', 'ShopTopController@commercialTransactions')->name('commercial_transactions');
        /**
         * 認証ユーザーのみアクセスできるルーティンググループ
         *
         * ※middleware→auth権限を持つユーザー以外は弾く
         */
        $router->group([
            'middleware' => 'auth',
        ], function (Router $router) {
            $router->get('/my-page', 'ShopTopController@myPage')->name('my_page');
        });
    });
    /**
     * ログイン処理に関するルーティンググループ
     *
     * ※namespace→ControllerはApp/Http/Controllers/Auth配下
     */
    $router->group([
        'namespace' => 'Auth',
    ], function (Router $router) {
        // ログイン画面表示
        $router->get('/login', 'LoginController@showLoginForm')->name('login');
        // ログイン処理
        $router->post('/login', 'LoginController@login');
        // ログアウト処理
        $router->post('/logout', 'LoginController@logout')->name('logout');
    });
});
