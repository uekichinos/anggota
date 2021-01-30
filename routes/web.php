<?php

// use App\Setting;
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

Route::get('/', function () {
    return view('welcome');
});

$relog = ['verify' => false, 'register' => false, 'reset' => false];

// $settings = Setting::ReLog();
$settings = DB::table('settings')->where('param', 'LIKE', 'relog_register')->orWhere('param', 'LIKE', 'relog_reset')->get();
if (count($settings) > 0) {
    foreach ($settings as $key => $setting) {
        $tmp = explode('_', $setting->param);
        $relog[$tmp[1]] = ($setting->value == 'yes' ? true : false);
    }
}

Auth::routes($relog);

Route::group(['prefix' => Config::get('app.backend_path'), 'middleware' => ['auth']], function () {
    Route::get('/accept', ['uses'=>'UserController@accept', 'as'=>'accept.index']);
    Route::post('/accept', ['uses'=>'UserController@sign', 'as'=>'sign.index']);
    Route::get('/accept/download', ['uses'=>'UserController@download', 'as'=>'accept.download']);

    Route::get('impersonate/revert', ['uses' => 'UserController@revert', 'as' => 'impersonate.revert']);
    Route::get('impersonate/{user}', ['uses' => 'UserController@impersonate', 'as' => 'impersonate.impersonate'])->middleware('permission:impersonate user');
});

Route::group(['prefix' => Config::get('app.backend_path'), 'middleware' => ['auth', 'accept']], function () {
    Route::post('/searchuser', 'UserController@searchuser');

    Route::get('/home', 'HomeController@index')->name('home');

    Route::get('/user', ['uses'=>'UserController@index', 'as'=>'user.index'])->middleware('permission:list user');
    Route::get('/user/create', ['uses'=>'UserController@create', 'as'=>'user.create'])->middleware('permission:create user');
    Route::post('/user/store', ['uses'=>'UserController@store', 'as'=>'user.store'])->middleware('permission:create user');
    Route::get('/user/show/{id}', ['uses'=>'UserController@show', 'as'=>'user.show'])->middleware('permission:view user');
    Route::get('/user/edit/{id}', ['uses'=>'UserController@edit', 'as'=>'user.edit'])->middleware('permission:edit user');
    Route::post('/user/update/{id}', ['uses'=>'UserController@update', 'as'=>'user.update'])->middleware('permission:edit user');
    Route::delete('/user/delete/{id}', ['uses'=>'UserController@destroy', 'as'=>'user.delete'])->middleware('permission:delete user');

    Route::get('/plan', ['uses'=>'PlanController@index', 'as'=>'plan.index'])->middleware('permission:list plan');
    Route::get('/plan/create', ['uses'=>'PlanController@create', 'as'=>'plan.create'])->middleware('permission:create plan');
    Route::post('/plan/store', ['uses'=>'PlanController@store', 'as'=>'plan.store'])->middleware('permission:create plan');
    Route::get('/plan/show/{id}', ['uses'=>'PlanController@show', 'as'=>'plan.show'])->middleware('permission:view plan');
    Route::get('/plan/edit/{id}', ['uses'=>'PlanController@edit', 'as'=>'plan.edit'])->middleware('permission:edit plan');
    Route::post('/plan/update/{id}', ['uses'=>'PlanController@update', 'as'=>'plan.update'])->middleware('permission:edit plan');
    Route::delete('/plan/delete/{id}', ['uses'=>'PlanController@destroy', 'as'=>'plan.delete'])->middleware('permission:delete plan');

    Route::get('/downline', ['uses'=>'DownlineController@index', 'as'=>'downline.index']);

    Route::get('/access/role', ['uses'=>'RoleController@index', 'as'=>'role.index'])->middleware('permission:list role');
    Route::get('/access/role/create', ['uses'=>'RoleController@create', 'as'=>'role.create'])->middleware('permission:create role');
    Route::post('/access/role/store', ['uses'=>'RoleController@store', 'as'=>'role.store'])->middleware('permission:create role');
    Route::get('/access/role/show/{id}', ['uses'=>'RoleController@show', 'as'=>'role.show'])->middleware('permission:view role');
    Route::get('/access/role/edit/{id}', ['uses'=>'RoleController@edit', 'as'=>'role.edit'])->middleware('permission:edit role');
    Route::post('/access/role/update/{id}', ['uses'=>'RoleController@update', 'as'=>'role.update'])->middleware('permission:edit role');
    Route::delete('/access/role/delete/{id}', ['uses'=>'RoleController@destroy', 'as'=>'role.delete'])->middleware('permission:delete role');

    Route::get('/access/permission', ['uses'=>'PermissionController@index', 'as'=>'permission.index'])->middleware('permission:list permission');

    Route::get('/profile/detail', ['uses' => 'ProfileController@edit', 'as' => 'profile.edit']);
    Route::post('/profile/detail', ['uses' => 'ProfileController@update', 'as' => 'profile.update']);
    Route::get('/profile/avatar', ['uses' => 'ProfileController@show_avatar', 'as' => 'avatar.show']);
    Route::post('/profile/avatar', ['uses' => 'ProfileController@update_avatar', 'as' => 'avatar.update']);
    Route::get('/profile/password', ['uses' => 'ProfileController@edit_password', 'as' => 'password.edit']);
    Route::post('/profile/password', ['uses' => 'ProfileController@update_password', 'as' => 'password.update']);

    Route::get('/audit/activitylog', ['uses'=>'ActivitylogController@index', 'as'=>'activitylog.index'])->middleware('permission:list activitylog');
    Route::get('/audit/activitylog/show/{id}', ['uses'=>'ActivitylogController@show', 'as'=>'activitylog.show'])->middleware('permission:view activitylog');
    Route::delete('/audit/activitylog/delete/{id}', ['uses'=>'ActivitylogController@destroy', 'as'=>'activitylog.delete'])->middleware('permission:delete activitylog');

    Route::get('/audit/logviewer', ['uses'=>'\Arcanedev\LogViewer\Http\Controllers\LogViewerController@index', 'as'=>'log-viewer::dashboard'])->middleware('permission:list logviewer');
    Route::get('/audit/logviewer/logs', ['uses'=>'\Arcanedev\LogViewer\Http\Controllers\LogViewerController@listLogs', 'as'=>'log-viewer::logs.list'])->middleware('permission:list logviewer');
    Route::delete('/audit/logviewer/logs/delete', ['uses'=>'\Arcanedev\LogViewer\Http\Controllers\LogViewerController@delete', 'as'=>'log-viewer::logs.delete'])->middleware('permission:delete logviewer');
    Route::get('/audit/logviewer/logs/{date}', ['uses'=>'\Arcanedev\LogViewer\Http\Controllers\LogViewerController@show', 'as'=>'log-viewer::logs.show'])->middleware('permission:view logviewer');
    Route::get('/audit/logviewer/logs/{date}/download', ['uses'=>'\Arcanedev\LogViewer\Http\Controllers\LogViewerController@download', 'as'=>'log-viewer::logs.download'])->middleware('permission:view logviewer');
    Route::get('/audit/logviewer/logs/{date}/{level}', ['uses'=>'\Arcanedev\LogViewer\Http\Controllers\LogViewerController@showByLevel', 'as'=>'log-viewer::logs.filter'])->middleware('permission:list logviewer');
    Route::get('/audit/logviewer/logs/{date}/{level}/search', ['uses'=>'\Arcanedev\LogViewer\Http\Controllers\LogViewerController@search', 'as'=>'log-viewer::logs.search'])->middleware('permission:list logviewer');

    Route::get('/setting/maintenance', ['uses'=>'SettingController@edit_maintenance', 'as'=>'setting.maintenance'])->middleware('permission:edit setting');
    Route::post('/setting/maintenance', ['uses'=>'SettingController@update_maintenance', 'as'=>'setting.maintenance'])->middleware('permission:edit setting');
    Route::get('/setting/ga', ['uses'=>'SettingController@edit_ga', 'as'=>'setting.ga'])->middleware('permission:edit setting');
    Route::post('/setting/ga', ['uses'=>'SettingController@update_ga', 'as'=>'setting.ga'])->middleware('permission:edit setting');
    Route::get('/setting/announce', ['uses'=>'SettingController@edit_announce', 'as'=>'setting.announce'])->middleware('permission:edit setting');
    Route::post('/setting/announce', ['uses'=>'SettingController@update_announce', 'as'=>'setting.announce'])->middleware('permission:edit setting');
    Route::get('/setting/password', ['uses'=>'SettingController@edit_password', 'as'=>'setting.password'])->middleware('permission:edit setting');
    Route::post('/setting/password', ['uses'=>'SettingController@update_password', 'as'=>'setting.password'])->middleware('permission:edit setting');
    Route::get('/setting/header', ['uses'=>'SettingController@edit_header', 'as'=>'setting.header'])->middleware('permission:edit setting');
    Route::post('/setting/header', ['uses'=>'SettingController@update_header', 'as'=>'setting.header'])->middleware('permission:edit setting');
    Route::get('/setting/relog', ['uses'=>'SettingController@edit_relog', 'as'=>'setting.relog'])->middleware('permission:edit setting');
    Route::post('/setting/relog', ['uses'=>'SettingController@update_relog', 'as'=>'setting.relog'])->middleware('permission:edit setting');
});
