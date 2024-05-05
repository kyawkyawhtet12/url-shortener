<?php

use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\LinkController;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/urls', function(){
    return view('url_shortener');
});

Route::post('/short_url', [LinkController::class, 'shortUrl'])->name('url.short');
Route::get('/{code}', [LinkController::class, 'redirectUrl'])->name('url.redirect');
Route::get('/migrate-force', function(){
    \Artisan::call('migrate --force');
});
