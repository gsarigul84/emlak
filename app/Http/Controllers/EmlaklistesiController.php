<?php

namespace App\Http\Controllers;

use App\Models\Emlakdetay;
use App\Models\Emlakgruplari;
use App\Models\Emlaklar;
use App\Models\Emlaktipleri;
use App\Models\Iller;
use Illuminate\Http\Request;

class EmlaklistesiController extends Controller
{
    //
    public function index(){
      $emlaklar = Emlaklar::with([
        'grup',
        'il',
        'ilce',
        'fiyat',
      ])
      ->where('durum', true)
      ->where(function($query){
        if(request()->has('post_type')){
          if(request()->post_type == 'for_sale'){
            $query->where('ilantipi', 'satilik');
          }
          if(request()->post_type == 'for_rent'){
            $query->where('ilantipi', 'kiralik');
          }
        }
        if(request()->has('type') && intval(request()->type) > 0){
          $query->where('tip_id', request()->type);
        }
        if(request()->has('city') && intval(request()->city) > 0){
          $query->where('il_id', request()->city);
        }
        if(request()->has('price_min') && intval(request()->price_min) > 0){
          $query->whereHas('fiyat', function($query){
            $query
              ->where('fiyat', '>=', request()->price_min)
              ->where('sembol', session('dovizcinsi'));
          });
        }
        if(request()->has('price_max') && intval(request()->price_max) > 0){
          $query->whereHas('fiyat', function($query){
            $query
              ->where('fiyat', '<=', request()->price_max)
              ->where('sembol', session('dovizcinsi'));
          });
        }
      })
      ->orderBy(
        match(request()->sort){
          'price_asc' => 'fiyat',
          'price_desc' => 'fiyat',
          'date_asc' => 'created_at',
          'date_desc' => 'created_at',
          default => 'created_at',
        },
      )
      ->paginate(10);

      $emlaklar->each(function ($item) {
        $item->setRelation('detay', Emlakdetay::where('dilkodu', app()->getLocale())->where('emlak_id', $item->id)->first());
        $item->setRelation('fiyat', $item->fiyat->keyBy('sembol'));
      });
      
      $emlakgruplari = Emlakgruplari::all();
      $emlaktipleri = Emlaktipleri::all();
      $iller = Iller::all();
      $emlaklar->appends(request()->query());

      return view('emlak-listesi',[
        'emlaklar' => $emlaklar,
        'emlakgruplari' => $emlakgruplari,
        'iller' => $iller,
        'emlaktipleri' => $emlaktipleri,
      ]);
    }
}
