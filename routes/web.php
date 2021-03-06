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

Route::post('/book', 'BookController@store');
Route::put('/book/{book}', 'BookController@update');
Route::delete('/book/{book}', 'BookController@destroy');

Route::get('/author/create', 'AuthorController@create');
Route::post('/authors','AuthorController@store');
Route::post('/checkout/{book}', 'CheckoutBookController@store');
Route::post('/checkin/{book}', 'CheckinBookController@store');


Route::get('/books', function (){
    return response(\App\Book::all());
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
