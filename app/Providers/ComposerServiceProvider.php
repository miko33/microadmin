<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use View;

class ComposerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        View::composer('*', 'App\Http\ViewComposers\ModuleComposer');
        View::composer(['home', 'pages.video.video', 'pages.category.category', 'pages.video.trash'], 'App\Http\ViewComposers\DivisionComposer');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
