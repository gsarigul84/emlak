<?php

namespace Database\Seeders;

use App\Models\Sabiticerik;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class IcerikSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        Sabiticerik::insert([
          ['icerikadi' => 'Hakkımızda', 'anahtar' => 'hakkimizda'],
          ['icerikadi' => 'İletişim', 'anahtar' => 'iletisim'],
          ['icerikadi' => 'Çerez politikası', 'anahtar' => 'cerez-politikasi'],
        ]);
    }
}
