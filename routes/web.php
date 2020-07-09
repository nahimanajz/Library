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

Route::post('/author','AuthorController@store');
Route::get('/books', function (){
    return response(\App\Book::all());
});
