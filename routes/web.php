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
Route::get('/group/{group}/berechnen', 'GroupController@berechnen');

Route::get('/group/{group}/teilnehmer', 'WzwController@showTeilnehmer');
Route::get('/group/{group}/addzahlung', 'WzwController@addZahlung');
Route::get('/group/{group}/addteilnehmer', 'WzwController@addTeilnehmer');
Route::put('/group/{group}/updatezahlung', 'WzwController@updateZahlung');
Route::put('/group/{group}/updateteilnehmer', 'WzwController@updateTeilnehmer');
Route::get('/group/{group}/endAbrechnung', 'WzwController@endAbrechnung');

Route::get('/aboutus', function () {
    return view('/footerpages/aboutus');
});

Route::get('/legal', function () {
    return view('/footerpages/legal');
});

Route::get('/privacy-policy', function () {
    return view('/footerpages/privacypolicy');
});




