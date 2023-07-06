<?php

namespace App\Console\Commands;

use App\Models\Diller;
use App\Models\Emlakdetay;
use App\Models\Emlakfiyatlari;
use App\Models\Emlakgruplari;
use App\Models\Emlaklar;
use App\Models\Emlaknitelikleri;
use App\Models\Emlakozellikleri;
use App\Models\Emlaktipleri;
use App\Models\Fiyatlandirma;
use App\Models\Ilceler;
use App\Models\Iller;
use App\Models\Mahalleler;
use App\Models\Nitelikler;
use App\Models\Ozellikgruplari;
use App\Models\Ozellikler;
use App\Models\Sabiticerik;
use App\Models\SabiticerikDetay;
use App\Models\Semtler;
use Illuminate\Console\Command;

class DummyDataCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:ornek-emlak';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Örnek emlaklar oluşturur.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
      $diller = Diller::all();
      $emlakgruplari = Emlakgruplari::all();
      $emlaktipleri = Emlaktipleri::all()->groupBy('grup_id');
      $nitelikler = Nitelikler::all();
      $ozellikler = Ozellikler::all();
      $limit = 40;
      foreach($emlakgruplari as $eg){
        for($l = 0; $l < $limit; $l ++){
          
        }
      }

    }
}
