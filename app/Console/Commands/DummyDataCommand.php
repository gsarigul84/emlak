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
    protected $signature = 'app:dummy-data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test için dummy data oluşturur.';

    /**
     * Execute the console command.
     */
    public function handle()
    {

    }
}
