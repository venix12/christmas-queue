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

Route::get('/', 'BeatmapController@index')->name('home');

Route::get('/users', function() {
    return view('users');
})->name('users');

Route::get('/beatmaps', 'BeatmapController@beatmaps')->name('beatmaps');

Route::get('/login', 'OAuthController@getToken')->name('login');
Route::get('/logout', function() {
    Auth::logout(Auth::user());
    return redirect()->back();
})->name('logout');

Route::group(['middleware' => 'is_ambassador', 'namespace' => 'Admin'], function() {
    Route::get('/admin-beatmaps', 'ManageBeatmapsController@index')->name('admin.beatmaps');
    Route::get('/admin-users', 'ManageUsersController@index')->name('admin.users');
    Route::get('/log', 'LogController@index')->name('admin.log');
    Route::post('/add-usergroup', 'ManageUsersController@addUsergroup')->name('add_usergroup');
    Route::post('/beatmap-approve', 'ManageBeatmapsController@approve');
    Route::post('/beatmap-delete', 'ManageBeatmapsController@delete');
    Route::post('/beatmap-restore', 'ManageBeatmapsController@restore');
    Route::get('/forum-export-beatmaps', 'ManageBeatmapsController@forumExport')->name('admin.forum-export-beatmaps');
    Route::get('/forum-export-modders', 'ManageUsersController@forumExport')->name('admin.forum-export-modders');
    Route::post('/switch-user-gamemode', 'ManageUsersController@switchGamemode')->name('admin.users.switch-gamemode');
});


Route::group(['prefix' => 'beatmaps'], function() {
    Route::post('/', 'BeatmapsetController@store');
    Route::post('/add-modder', 'ModController@store');
    Route::post('/remove-modder', 'ModController@remove');
});

//API
Route::group(['namespace' => 'api', 'prefix' => 'api'], function() {
    Route::get('/mods', 'ModController@index');
    Route::get('/mods/{id}', 'ModController@show');
    Route::get('/nominators', 'ModController@nominatorsIndex');
    Route::get('/nominators/{id}', 'ModController@nominatorsShow');
});

//osu! OAuth
Route::get('/callback', 'OAuthController@getUserData')->name('oauth-callback');
