<?php

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
//php artisan route:list //查看有效的注册路由

Route::get('/', function () {
    return view('welcome');
});
/*
Route::get('/articles', 'ArticlesController@index');
Route::get('/articles/create', 'ArticlesController@create'); //访问“创建新文章”视图
//路由从上往下加载，遇见第一个符合相同url和请求方式条件的路由，加载并停止往下。此处id路由在上，create会误作参数，而不加载/articles/create路由。
Route::get('/articles/{id}', 'ArticlesController@show');

Route::post('/articles', 'ArticlesController@store'); //“创建新文章”视图的form表单将数据存入数据库

Route::get('/articles/{id}/edit', 'ArticlesController@edit');
*/
Route::resource('articles', 'ArticlesController'); //一个顶前面所有的，资源控制器

/* laravel5.1
Route::get('auth/login', 'Auth\AuthController@getLogin');//登录表单
Route::post('auth/login', 'Auth\AuthController@postLogin');//验证登录
Route::get('auth/register', 'Auth\AuthController@getRegister');//注册表单
Route::post('auth/register', 'Auth\AuthController@postRegister');//验证注册
Route::get('auth/logout', 'Auth\AuthController@getLogout');//退出登录
*/

//php artisan make:auth的标准生产代码
Auth::routes(); 
Route::get('/home', 'HomeController@index')->name('home');


