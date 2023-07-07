<?php

use App\Http\Controllers\SeceneklerController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function(){
  if(session('language')){
    return redirect()->to('/'.session('language'));
  }
  return redirect()->to('/'.app()->getLocale());
});
include_once('site.php');

Route::get('set-doviz-cinsi', [SeceneklerController::class, 'dovizCinsi'])->name('set-doviz-cinsi');
// TODO: 404 eklenebilir
// Route::fallback(function () {
// 	return redirect()->route('filament.auth.login');
// })
// ->name('login');