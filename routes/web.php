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

Route::get('/', function () {
    return view('welcome');
});

//List routes
Route::get('list', 'MailChimpController@index')->name('list');
Route::get('list/view/{id}', 'MailChimpController@view')->name('list.view');

Route::get('list/new', 'MailChimpController@newMailChimpList')->name('list.create');
Route::post('list/create', 'MailChimpController@createMailChimpList')->name('list.store');

Route::get('list/update/{id}', 'MailChimpController@editMailChimpList')->name('list.edit');
Route::post('list/update/{id}', 'MailChimpController@updateMailChimpList')->name('list.update');

Route::get('list/delete/{id}', 'MailChimpController@deleteMailChimpList')->name('list.delete');

//Subscribtion routes
Route::get('subscribers/{id}', 'SubscriberController@listSubscribers')->name('subscribers');

Route::get('subscribers/new/{id}', 'SubscriberController@newSubscriber')->name('subscribtion.create');
Route::post('subscribers/create', 'SubscriberController@create')->name('subscribtion.store');

Route::get('subscribers/update/{id}', 'SubscriberController@edit')->name('subscribtion.edit');
Route::post('subscribers/update/{id}', 'SubscriberController@update')->name('subscribtion.update');

Route::get('subscribers/delete/{id}', 'SubscriberController@delete')->name('subscribtion.delete');