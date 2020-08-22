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

Route::get('/', [
    'uses'  => 'UserController@index',
    'as'    => 'user.feedback'
]);

Route::get('/greeting', [
    'uses'  => 'UserController@greeting',
    'as'    => 'user.feedback.greeting'
]);

Route::post('/', [
    'uses'  => 'UserController@store',
    'as'    => 'user.feedback'
]);

Route::post('/user/answer', [
    'uses'  => 'UserController@answer_store',
    'as'    => 'user.answer'
]);