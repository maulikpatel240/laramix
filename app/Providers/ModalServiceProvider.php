<?php

namespace App\Providers;

use App\BsModal\Modal;
use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;

class ModalServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        App::bind('modal',function() {
            return new Modal();
         });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}