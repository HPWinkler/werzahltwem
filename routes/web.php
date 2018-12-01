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
    return view('startseite');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::resource('/group', 'GroupController');
Route::get('/group/{group}/teilnehmer', 'GroupController@showTeilnehmer');
Route::get('/group/{group}/addzahlung', 'GroupController@addZahlung');
Route::get('/group/{group}/addteilnehmer', 'GroupController@addTeilnehmer');
Route::put('/group/{group}/updatezahlung', 'GroupController@updateZahlung');
Route::put('/group/{group}/updateteilnehmer', 'GroupController@updateTeilnehmer');
Route::get('/group/{group}/berechnen', 'GroupController@berechnen');
Route::get('/group/{group}/endAbrechnung', 'GroupController@endAbrechnung');

Route::get('/aboutus', function () {
    return view('/footerpages/aboutus');
});

Route::get('/legal', function () {
    return view('/footerpages/legal');
});

Route::get('/privacy-policy', function () {
    return view('/footerpages/privacypolicy');
});




