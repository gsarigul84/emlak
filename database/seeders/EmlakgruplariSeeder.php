<?php

namespace Database\Seeders;

use App\Models\Diller;
use App\Models\Emlakgruplari;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EmlakgruplariSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $diller = Diller::all();
        foreach(['Arsa','Konut'] as $emlakgrubu){
          $eg = Emlakgruplari::create([
            
          ]);
          foreach($diller as $d){
            
          }
        }
    }
}
