<?php

namespace App\Providers;

use illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;
use Route;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Paginator::useBootstrap();
        
        /*Route::resourceVerbs([
            'create' => 'cadastrar',
            'edit' => 'editar',
        ]);*/
    }
}
