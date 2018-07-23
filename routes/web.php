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

Route::get('/', 'PagesController@home');
Route::get('/about', 'PagesController@about');
Route::get('/contact', 'TicketsController@create');
Route::post('/contact', 'TicketsController@store');

Route::get('/tickets','TicketsController@index');
Route::get('/tickets/{slug}','TicketsController@show');
Route::get('/tickets/{slug}/edit','TicketsController@edit');
Route::post('/tickets/{slug}/edit','TicketsController@update');
Route::post('/tickets/{slug}/delete','TicketsController@destroy');

Route::post('/comment','CommentsController@newComment');

Route::get('sendmail',function() {
    $data = array('name'=> "LL");
    Mail::send('emails.welcome', $data, function ($message) {
        $message->from('thanhthuk59@gmail.com', 'LL');
        $message->to('phan.thanh.thu@framgia.com')->subject("LL test mail");
    });
    return "your email is sent ok";
});

Route::get('/thanhthu', function () {
    return view('thanhthu');
});
