<?php

namespace Database\Seeders;

use App\Models\Diller;
use App\Models\Ozellikgruplari;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OzelliklerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $diller = Diller::all();
        $ozellikgruplari = [
          'Manzara' => ['tr' => 'Manzara','en' => 'View'],
          'Konum' => ['tr' => 'Konum','en' => 'Location'],
          'İç mekan' => ['tr' => 'İç mekan','en' => 'Interior'],
          'Dış mekan' => ['tr' => 'Dış mekan','en' => 'Exterior'],
        ];
        foreach($ozellikgruplari as $ad => $veri){
          
        }
    }
}
