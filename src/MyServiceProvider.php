<?php

namespace Norge\Mymap;

use Laravel\Nova\Nova;
use Laravel\Nova\Events\ServingNova;
use Illuminate\Support\ServiceProvider;

class MyServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function myboot()
    {
        Nova::serving(function (ServingNova $event) {
            Nova::script('myamap', __DIR__.'/../dist/js/field.js');
            Nova::style('myamap', __DIR__.'/../dist/css/field.css');
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
