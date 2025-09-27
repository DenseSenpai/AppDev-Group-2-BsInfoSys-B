<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Http\Responses\LoginResponse;
use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;

class AppServiceProvider extends ServiceProvider
{
  
    public function register(): void
    {
        // ✅ Bind our custom LoginResponse to Fortify
        $this->app->singleton(LoginResponseContract::class, LoginResponse::class);
    }

    
    public function boot(): void
    {
        //
    }
}
