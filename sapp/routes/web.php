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
//use Goutte\Client;
use JonnyW\PhantomJs\Client;
Route::get('/', function () {
    
   return view('pages.dash');
    

});
Route::get('/dash','PagesController@dash');
Route::resource('post', 'PostsController');
