<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SeceneklerController extends Controller
{
  //

  public function dovizCinsi(){
    if(request()->has('dovizcinsi')){
      session(['dovizcinsi' => request('dovizcinsi')]);
    }
    return response()->json([
      'status' => 1,
      'message' => 'Döviz cinsi değiştirildi.',
      'dovizcinsi' => session('dovizcinsi')
    ]);
  }

  public function cookieConsent(){
    session(['cookie-consent' => true]);
    
    return response()->json([
      'status' => 1,
      'message' => 'Çerez politikası kabul edildi.',
      'cookieconsent' => session('cookieconsent')
    ]);
  }
}
