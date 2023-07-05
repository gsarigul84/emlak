<?php

namespace App\Http\Controllers;

use App\Models\Emlakgruplari;
use App\Models\Emlaklar;
use App\Models\Emlaktipleri;
use App\Models\Iller;
use Illuminate\Http\Request;

class AnasayfaController extends Controller
{
    //
    public function index(){
      $emlakgruplari = Emlakgruplari::all();
      $iller = Iller::all();
      $sonilanlar = Emlaklar::orderBy('id','desc')
        ->with([
          'grup',
          'il',
          'ilce',
          'fiyat',
        ])
        ->take(10)
        ->get();
      return view('home',[
        'emlakgruplari' => $emlakgruplari,
        'iller' => $iller,
        'sonilanlar' => $sonilanlar,
      ]);
    }
}
