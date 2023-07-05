<?php

namespace App\Filament\Pages;

use App\Http\Controllers\BlogController;
use App\Http\Controllers\EmlakdetayController;
use App\Http\Controllers\EmlaklistesiController;
use App\Http\Controllers\IcerikController;
use App\Http\Controllers\PostController;
use App\Models\Ayarlar as ModelAyarlar;
use App\Models\Diller;
use Filament\Forms;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Tabs;
use Filament\Pages\Page;
use Illuminate\Support\Facades\Storage;
use Livewire\TemporaryUploadedFile;

class Ayarlar extends Page
{
  protected static ?string $navigationIcon = 'heroicon-o-document-text';

  protected static string $view = 'filament.pages.ayarlar';

  protected static ?int $navigationSort = 100;

  protected static function getNavigationGroup(): string
  {
    return __('menu.ayarlar');
  }

  protected static function getNavigationLabel(): string
  {
    return __('menu.ayarlar');
  }

  public function mount()
  {
    $base = [
      'logo' => '',
    ];
    $ayarlar = ModelAyarlar::all();
    $this->form->fill(
      array_merge(
        $base,
        $ayarlar->keyBy('anahtar')
          ->map(fn ($item) => $item->ekdeger ? $item->ekdeger : $item->deger)
          ->toArray()
      )
    );
  }

  protected function getFormSchema(): array
  {
    $diller = Diller::all();
    $tabs = [];
    foreach ($diller as $d) {
      $tabs[] = Tabs\Tab::make($d->diladi)
        ->label($d->diladi)
        ->schema([
          Forms\Components\TextInput::make('sitetitle.' . $d->dilkodu)
            ->label(__('form.site_title')),
          Forms\Components\TextInput::make('sitedescription.' . $d->dilkodu)
            ->label(__('form.site_description')),
          Forms\Components\TextInput::make('ektitle.' . $d->dilkodu)
            ->label(__('form.ek_title'))
            ->helperText(__('form.ek_title_helper')),
          Forms\Components\TextInput::make('ek_description.' . $d->dilkodu)
            ->label(__('form.ek_description'))
            ->helperText(__('form.ek_description_helper')),
          Forms\Components\TextInput::make('emlaklistesi_prefix.' . $d->dilkodu)
            ->label(__('form.emlakliste_url_prefix'))
            ->helperText(__('form.emlakliste_url_prefix_helper')),
          Forms\Components\TextInput::make('emlakdetay_prefix.' . $d->dilkodu)
            ->label(__('form.emlak_url_prefix'))
            ->helperText(__('form.emlak_url_prefix_helper')),
          Forms\Components\TextInput::make('icerik_prefix.' . $d->dilkodu)
            ->label(__('form.icerik_url_prefix'))
            ->helperText(__('form.icerik_url_prefix_helper')),
          Forms\Components\TextInput::make('blog_prefix.' . $d->dilkodu)
            ->label(__('form.blog_url_prefix'))
            ->helperText(__('form.blog_url_prefix_helper')),
          Forms\Components\TextInput::make('post_prefix.' . $d->dilkodu)
            ->label(__('form.post_url_prefix'))
            ->helperText(__('form.post_url_prefix_helper')),
        ]);
    }

    return [
      Grid::make([
        'lg' => 2,
        'sm' => 1,
      ])->columns(3)->schema([
        Card::make()->schema([
          Section::make(__('form.logo_ve_seo'))
            ->schema([
              Forms\Components\FileUpload::make('logo')
                ->label(__('form.logo'))
                ->rules('nullable')
                ->getUploadedFileNameForStorageUsing(function (TemporaryUploadedFile $file): string {
                  $ext = explode('.', $file->getClientOriginalName());
                  $ext = end($ext);

                  return (string) 'logo.' . $ext;
                })
                ->image(),
              Forms\Components\TextInput::make('title_ayrac')
                ->label(__('form.title_ayrac')),
            ]),
          Section::make(__('form.sosyal_medya'))
            ->schema([
              Forms\Components\TextInput::make('facebook_url')
                ->label(__('form.facebook_url')),
              Forms\Components\TextInput::make('twitter_url')
                ->label(__('form.twitter_url')),
              Forms\Components\TextInput::make('linkedin_url')
                ->label(__('form.linkedin_url')),
            ]),
        ])->columnSpan(1),
        Card::make()->label('Meta')->schema([
          Tabs::make('tabs')->tabs($tabs),
        ])->columnSpan(2),
      ]),
    ];
  }

  public function submit()
  {
    $state = $this->form->getState();
    foreach ($state as $key => $value) {
      if ($key == 'logo') {
        // $ext = $value->getClientOriginalExtension();
        // Storage::disk('public')->put('logo.jpg', file_get_contents($value));
      }
      $ekdeger = '';
      if (is_array($value)) {
        $ekdeger = $value;
        $value = '';
      }
      ModelAyarlar::firstOrCreate([
        'anahtar' => $key,
      ])->update([
        'deger' => $value,
        'ekdeger' => $ekdeger,
      ]);
    }
    $diller = Diller::all();
    $yollar = [];
    foreach($diller as $dil){
      $yollar[] = "Route::group(['prefix' => '".$dil->dilkodu."', 'as' => '".$dil->dilkodu.".'], function () {";
      $yollar[] = "Route::get('/', [AnasayfaController::class, 'index'])->name('home');";
      $yollar[] = "Route::get('/".$state['icerik_prefix'][$dil->dilkodu]."/{slug}', [IcerikController::class, 'index'])->name('icerik');";
      $yollar[] = "Route::get('/".$state['emlaklistesi_prefix'][$dil->dilkodu]."', [EmlaklistesiController::class, 'index'])->name('emlaklistesi');";
      $yollar[] = "Route::get('/".$state['emlakdetay_prefix'][$dil->dilkodu]."/{slug}', [EmlakdetayController::class, 'detay'])->name('emlakdetay');";
      $yollar[] = "Route::get('/".$state['blog_prefix'][$dil->dilkodu]."/{slug}', [BlogController::class, 'index'])->name('blog');";
      $yollar[] = "Route::get('/".$state['post_prefix'][$dil->dilkodu]."/{slug}', [PostController::class, 'detay'])->name('post');";
      $yollar[] = "});";
    }
    $yollar = implode("\r\n", $yollar);
    $router = <<<EOT
<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AnasayfaController;
use App\Http\Controllers\IcerikController;
use App\Http\Controllers\EmlaklistesiController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\EmlakdetayController;
use App\Http\Controllers\PostController;
Route::group(['middleware' => ['dil','site']], function(){
  $yollar
});
;
EOT;
    file_put_contents(base_path('routes/site.php'), $router);
  }
}
