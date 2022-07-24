<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

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
        app('view')->composer('*', function ($view) {
            if (app('request')->route() && app('request')->route()->getAction() != null) {
                $getActionName = app('request')->route()->getAction();
                if (isset($getActionName['middleware']) && count($getActionName['middleware']) >= 2 && is_array($getActionName['middleware'])) {
                    if (in_array('auth:admin', $getActionName['middleware']) || in_array('guest:admin', $getActionName['middleware'])) {
                        if (isset($getActionName['controller']) && $getActionName['controller']) {

                            $getControllerName = class_basename($getActionName['controller']);
                            list($getControllerName, $getActionName) = explode('@', $getControllerName);

                            $getControllerName = strtolower(str_replace('Controller', '', $getControllerName));
                            $view->with(compact('getControllerName', 'getActionName'));
                        }
                    }
                }
            }
        });
    }
}