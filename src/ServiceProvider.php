<?php

namespace Minhbang\Setting;

use Illuminate\Support\ServiceProvider as BaseServiceProvider;
use Illuminate\Foundation\AliasLoader;

/**
 * Class ServiceProvider
 *
 * @package Minhbang\Setting
 */
class ServiceProvider extends BaseServiceProvider
{

    public function boot()
    {
        //$this->loadTranslationsFrom(__DIR__ . '/../lang', 'setting');
        $this->loadViewsFrom(__DIR__ . '/../views', 'setting');
        $this->loadRoutesFrom(__DIR__ . '/routes.php');
        $this->publishes(
            [
                __DIR__ . '/../views'              => base_path('resources/views/vendor/setting'),
                //__DIR__ . '/../lang'               => base_path('resources/lang/vendor/setting'),
                __DIR__ . '/../config/setting.php' => config_path('setting.php'),
            ]
        );

        if($this->app->has('menu-manager')){
            app('menu-manager')->addItems(config('setting.menus'));
        }
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/setting.php', 'setting');
        $this->app->singleton('setting', function () {
            return new Setting(
                config('setting.path'),
                config('setting.zones')
            );
        });
        // add Setting alias
        $this->app->booting(
            function () {
                AliasLoader::getInstance()->alias('Setting', Facade::class);
            }
        );
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['setting'];
    }
}
