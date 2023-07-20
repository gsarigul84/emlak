<?php

namespace App\Http\Controllers;

use App\Models\Ayarlar;
use App\Models\Sabiticerik;
use App\Models\SabiticerikDetay;
use Illuminate\Http\Request;

use Artesaos\SEOTools\Facades\SEOMeta;


class HakkimizdaController extends Controller
{
  //
  public function index()
  {
    $sabiticerik = Sabiticerik::where('anahtar', 'hakkimizda')
      ->first();
    if (!$sabiticerik) {
      abort(404);
    }
    $detay = SabiticerikDetay::where('icerik_id', $sabiticerik->id)
      ->where('dilkodu', app()->getLocale())
      ->first();
    $ayarlar = Ayarlar::whereIn('anahtar', ['ektitle', 'ek_description', 'title_ayrac'])
      ->get()
      ->keyBy('anahtar');

    SEOMeta::setTitle($detay->baslik
      .' '. $ayarlar['title_ayrac']->deger.' '
      . $ayarlar['ektitle']->ekdeger[app()->getLocale()]);
    SEOMeta::setDescription(rtrim($detay->aciklama, '.') . '. '
      . $ayarlar['ek_description']->ekdeger[app()->getLocale()]);
    return view('sabit-icerik', [
      'icerik' => $detay,
    ]);
  }
}
