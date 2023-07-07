<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EmlakdetayController extends Controller
{
    //
    public function detay($slug, $id){
      return view('emlakdetay');
    }
}
