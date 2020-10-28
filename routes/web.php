<?php

use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Fortify;


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
Route::get('/home',function ()
{
    return view('home');

});

Route::group(['namespace' => 'App\Http\Controllers\Admin' , 'prefix' => 'admin'],function (){
    Route::get('/panel' , 'PanelController@index');
    Route::post('/panel/upload-image' , 'PanelController@uploadImageSubject');
    Route::resource('articles' , 'ArticleController')->middleware('can:send-article');
    Route::resource('courses' , 'CourseController');
    Route::resource('episodes' , 'EpisodeController');
    Route::resource('roles' , 'RoleController');
    Route::resource('permissions' , 'PermissionController');

    Route::group(['prefix' => 'users'],function (){
        Route::get('/' , 'UserController@index');
        Route::resource('level' , 'LevelManageController' , ['parameters' => ['level' => 'user']]);
        Route::delete('/{user}/destroy' , 'UserController@destroy')->name('users.destroy');
    });
});
