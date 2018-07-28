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

Route::get('/', 'CrawlerController@index');
Route::get('search', 'CrawlerController@crawl');
Route::get('comic/{comic}', 'CrawlerController@getDetailComic')->name('comic');
Route::get('read/{comic}/{id}', 'CrawlerController@readComic')->name('read');