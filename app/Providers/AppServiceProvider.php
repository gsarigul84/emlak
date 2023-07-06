<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
	/**
	 * Register any application services.
	 */
	public function register(): void
	{
		//
    
	}

	/**
	 * Bootstrap any application services.
	 */
	public function boot(): void
	{
		//
		
    Gate::define('use-translation-manager', function (?User $user) {
			// Your authorization logic
			// return true;
			return $user !== null && $user->is_admin;
		});
    
	}
}
