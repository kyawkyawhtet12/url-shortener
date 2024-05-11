<?php

use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\LinkController;


Route::get('/', function () {
    return view('url_shortener');
});

Route::get('/redirect', function(){
    return view('redirect', ['redirect_url'=>'www.google.com']);
});

Route::post('/short_url', [LinkController::class, 'shortUrl'])->name('url.short');
Route::get('/{code}', [LinkController::class, 'redirectUrl'])->name('url.redirect');
