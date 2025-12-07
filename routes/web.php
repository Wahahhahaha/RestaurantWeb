<?php

use Illuminate\Support\Facades\Route;

Route::get('/login', 'App\Http\Controllers\Ctrl@login');
Route::post('/logindata', 'App\Http\Controllers\Ctrl@loginact');
Route::get('/register', 'App\Http\Controllers\Ctrl@regis');
Route::post('/registerdata', 'App\Http\Controllers\Ctrl@registact');
Route::get('/logout', 'App\Http\Controllers\Ctrl@logout');

Route::get('/home', 'App\Http\Controllers\Ctrl@home');

Route::get('/profile', 'App\Http\Controllers\Ctrl@profile');

Route::get('/userdata', 'App\Http\Controllers\Ctrl@userdata');
Route::get('/userdata/search', 'App\Http\Controllers\Ctrl@userdataJson');
Route::get('/deleteuser/{id}', 'App\Http\Controllers\Ctrl@deleteuser');
Route::post('/resetpassword/{id}', 'App\Http\Controllers\Ctrl@resetpass');

Route::get('/cart', 'App\Http\Controllers\Ctrl@cart');
Route::post('/addcart', 'App\Http\Controllers\Ctrl@store');
Route::get('/removecart/{id}', 'App\Http\Controllers\Ctrl@remove');

Route::post('/checkout', 'App\Http\Controllers\Ctrl@checkout');
Route::post('/payment', 'App\Http\Controllers\Ctrl@pay');

Route::get('/editusers/{id}', 'App\Http\Controllers\Ctrl@edituser');
Route::post('/updateuser/{id}', 'App\Http\Controllers\Ctrl@updateuser');

Route::get('/historytransaction', 'App\Http\Controllers\Ctrl@historytransaction');
Route::get('/historytransaction/search', 'App\Http\Controllers\Ctrl@historytransactionsearch');
Route::get('/detailhistory/{id}', 'App\Http\Controllers\Ctrl@historydetail');

Route::get('/report', 'App\Http\Controllers\Ctrl@report');
Route::get('/report/search', 'App\Http\Controllers\Ctrl@reports');
Route::get('/printmonthlyreport', 'App\Http\Controllers\Ctrl@monthreport');
Route::get('/pdfmonthlyreport', 'App\Http\Controllers\Ctrl@pdfmonth');
Route::get('/excelmonthlyreport', 'App\Http\Controllers\Ctrl@excelmonth');

Route::get('/daily', 'App\Http\Controllers\Ctrl@daily');
Route::get('/daily/search', 'App\Http\Controllers\Ctrl@dailys');
Route::get('/dailyreport', 'App\Http\Controllers\Ctrl@dailyreport');
Route::get('/pdfdailyreport', 'App\Http\Controllers\Ctrl@pdfdaily');
Route::get('/exceldailyreport', 'App\Http\Controllers\Ctrl@exceldaily');

Route::get('/promotions', 'App\Http\Controllers\Ctrl@promotion');
Route::get('/addpromotion', 'App\Http\Controllers\Ctrl@addpromo');
Route::get('/editpromotion/{name}', 'App\Http\Controllers\Ctrl@editpromo');
Route::post('/savepromotion/{name}', 'App\Http\Controllers\Ctrl@savepromo');
Route::post('/savepromotions', 'App\Http\Controllers\Ctrl@savepromoadd');
Route::get('/deletepromotion/{name}', 'App\Http\Controllers\Ctrl@deletepromo');

Route::get('/menu', 'App\Http\Controllers\Ctrl@menudata');
Route::get('/menu/search', 'App\Http\Controllers\Ctrl@menudatajson');
Route::get('/insertmenu', 'App\Http\Controllers\Ctrl@inputmenu');
Route::get('/editmenu/{id}', 'App\Http\Controllers\Ctrl@editmenu');
Route::post('/savemenu/{id}', 'App\Http\Controllers\Ctrl@savemenu');
Route::get('/deletemenu/{id}', 'App\Http\Controllers\Ctrl@deletemenu');

Route::get('/courier/orders', 'App\Http\Controllers\Ctrl@courierOrders');
Route::post('/courier/status/{id}', 'App\Http\Controllers\Ctrl@updateStatus');	
