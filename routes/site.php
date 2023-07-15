<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AnasayfaController;
use App\Http\Controllers\IcerikController;
use App\Http\Controllers\EmlaklistesiController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\EmlakdetayController;
use App\Http\Controllers\PostController;
Route::group(['middleware' => ['dil','site']], function(){
  Route::group(['prefix' => 'tr', 'as' => 'tr.'], function () {
Route::get('/', [AnasayfaController::class, 'index'])->name('home');
Route::get('/icerik/{slug}', [IcerikController::class, 'index'])->name('icerik');
Route::get('/emlaklar', [EmlaklistesiController::class, 'index'])->name('emlaklistesi');
Route::get('/emlak-detay/{slug}/{id}', [EmlakdetayController::class, 'detay'])->name('emlakdetay');
Route::get('/blog/{slug}', [BlogController::class, 'index'])->name('blog');
Route::get('/post/{slug}/{id}', [PostController::class, 'detay'])->name('post');
});
Route::group(['prefix' => 'en', 'as' => 'en.'], function () {
Route::get('/', [AnasayfaController::class, 'index'])->name('home');
Route::get('/content/{slug}', [IcerikController::class, 'index'])->name('icerik');
Route::get('/properties', [EmlaklistesiController::class, 'index'])->name('emlaklistesi');
Route::get('/details/{slug}/{id}', [EmlakdetayController::class, 'detay'])->name('emlakdetay');
Route::get('/blog/{slug}', [BlogController::class, 'index'])->name('blog');
Route::get('/post/{slug}/{id}', [PostController::class, 'detay'])->name('post');
});
});
;