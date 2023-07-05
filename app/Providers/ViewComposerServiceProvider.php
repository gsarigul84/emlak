<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewComposerServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //,
        View::composer('*', function($view){
          $diller = \App\Models\Diller::all();
          $dovizcinsleri = \App\Models\Fiyatlandirma::all();
          $view
            ->with('diller', $diller->keyBy('dilkodu'))
            ->with('dovizcinsleri', $dovizcinsleri);
        });
    }
}
