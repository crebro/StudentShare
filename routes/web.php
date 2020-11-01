<?php

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

// Route::get('/', function () {
//     return view('home');
// });

Route::get('mygroups', "GroupsController@myGroups")->name('mygroups');

Auth::routes();
Route::get('/home', "HomeController@index");
Route::get('/', 'HomeController@index')->name('home');
Route::resource('/groups', 'GroupsController');
Route::post('groupJoin/{userId}/{groupId}', 'GroupsController@addRequest')->name('groupJoin');
Route::post('groupAccept/{userId}/{groupId}', 'GroupsController@acceptRequest')->name('groupAccept');
Route::post('sendMessage', 'GroupMessageController@sendMessage' )->name('sendMessage');
Route::get('getMessages/{groupId}', "GroupMessageController@getMessages")->name('getMessages');
Route::post('shareImage', "GroupMessageController@sendFile"  )->name('shareImage');