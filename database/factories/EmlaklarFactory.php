<?php

namespace Database\Factories;

use App\Models\Diller;
use App\Models\Emlakdetay;
use App\Models\Emlakfiyatlari;
use App\Models\Emlakgruplari;
use App\Models\Emlaklar;
use App\Models\Emlaktipleri;
use App\Models\Fiyatlandirma;
use App\Models\Ilceler;
use App\Models\Iller;
use App\Models\Mahalleler;
use App\Models\Semtler;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Emlaklar>
 */
class EmlaklarFactory extends Factory
{
  /**
   * Define the model's default state.
   *
   * @return array<string, mixed>
   */
  public function definition(): array
  {
    $eg = Emlakgruplari::inRandomOrder()->first();
    $il = Iller::inRandomOrder()->first();
    return [
      'grup_id' => $eg->id,
      'tip_id' => function () use ($eg) {
        return Emlaktipleri::where('grup_id', $eg->id)->inRandomOrder()->first();
      },
      'ilantipi' => $this->faker->randomElement(['Satılık', 'Kiralık']),
      'ilan_no' => $this->faker->unique()->randomNumber(),
      'il_id' => $il->id,
      'ilce_id' => function () use ($il) {
        return Ilceler::where('il_id', $il->id)->inRandomOrder()->first();
      },
      'semt_id' => function () use ($il) {
        return Semtler::where('il_id', $il->id)->inRandomOrder()->first();
      },
      'mahalle_id' => function () use ($il) {
        return Mahalleler::where('il_id', $il->id)->inRandomOrder()->first();
      },
      'koordinatlar' => [
        // Define the structure of the 'koordinatlar' array
        // based on your requirements and faker methods.
        // Example:
        'latitude' => $this->faker->latitude,
        'longitude' => $this->faker->longitude,
      ],
      'gorseller' => function () {
        $filePaths = [];
        $fileCount = $this->faker->numberBetween(1, 5); // Set the range for the number of files

        for ($i = 0; $i < $fileCount; $i++) {
          $response = Http::get('https://picsum.photos/1920/1080');
          $imageContents = $response->getBody();
          $rand = uniqid();
          $filePath = "{$rand}.jpg"; // Adjust the storage path and file name as needed
          Storage::put("public/".$filePath, $imageContents);
          $filePaths[] = $filePath;
        }

        return $filePaths;
      },
      'durum' => $this->faker->randomElement([true, false]),
    ];
  }

  public function configure()
  {
    $diller = Diller::select('dilkodu')->get()->toArray();
    $fiyatlandirma = Fiyatlandirma::all();
    return $this->afterCreating(function (Emlaklar $emlaklar) use ($diller, $fiyatlandirma) {
      $emlakdetay = [];
      $fiyatlar = [];
      foreach ($diller as $dil) {
        $emlakdetay[] = Emlakdetay::factory()->create([
          'emlak_id' => $emlaklar->id,
          'dilkodu' => $dil['dilkodu'],
        ]);
      }
      foreach($fiyatlandirma as $fiyat){
        $fiyatlar[] = Emlakfiyatlari::create([
          'sembol' => $fiyat->sembol,
          'fiyat' => $this->faker->numberBetween(100000, 1000000),
          'emlak_id' => $emlaklar->id,
        ]);
      }
      $emlaklar->detay()->saveMany($emlakdetay);
      $emlaklar->fiyat()->saveMany($fiyatlar);
    });
  }
}
