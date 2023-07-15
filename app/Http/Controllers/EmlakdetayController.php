<?php

namespace App\Http\Controllers;

use App\Models\Ayarlar;
use App\Models\Emlakdetay;
use App\Models\Emlaklar;
use App\Models\Emlaknitelikleri;
use App\Models\Emlakozellikleri;
use App\Models\Nitelikler;
use App\Models\Ozellikler;
use Illuminate\Http\Request;

use Artesaos\SEOTools\Facades\SEOMeta;
class EmlakdetayController extends Controller
{
    //
    public function detay($slug, $id){
      $emlak = Emlaklar::where('id',$id)
        ->with([
          'grup',
          'tip',
          'il',
          'ilce',
          'semt',
          'mahalle',
        ])
        ->first();
      if(!$emlak){
        abort(404);
      }

      $ozellikler = Ozellikler::all()->groupBy('grup_id')
        ->map(function ($item, $key) {
          return $item->keyBy('id');
        });
      $nitelikler = Nitelikler::all()->keyBy('id');

      $emlak->setRelation('detay', Emlakdetay::where('dilkodu', app()->getLocale())->where('emlak_id', $emlak->id)->first());
      $emlak->setRelation('fiyat', $emlak->fiyat->keyBy('sembol'));
      $emlak->setRelation('nitelik', Emlaknitelikleri::where('emlak_id', $emlak->id)->get()->keyBy('nitelik_id') );
      $emlak->setRelation('ozellik', Emlakozellikleri::where('emlak_id', $emlak->id)->get()->keyBy('ozellik_id') );
      SEOMeta::setTitle($emlak->detay->baslik);
      SEOMeta::setTitle($emlak->detay->aciklama);

      $maps_key = Ayarlar::where('anahtar','google_maps_key')->first()?->deger;

      return view('emlakdetay',[
        'emlak' => $emlak,
        'nitelikler' => $nitelikler,
        'ozellikler' => $ozellikler,
        'maps_key' => $maps_key,
      ]);
    }
}
