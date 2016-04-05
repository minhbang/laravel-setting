<?php

namespace Minhbang\Setting;

use Minhbang\Kit\Extensions\BaseServiceProvider;
use Illuminate\Foundation\AliasLoader;

class ServiceProvider extends BaseServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadTranslationsFrom(__DIR__ . '/../lang', 'setting');
        $this->loadViewsFrom(__DIR__ . '/../views', 'setting');
        $this->publishes(
            [
                __DIR__ . '/../views'              => base_path('resources/views/vendor/setting'),
                __DIR__ . '/../lang'               => base_path('resources/lang/vendor/setting'),
                __DIR__ . '/../config/setting.php' => config_path('setting.php'),
            ]
        );
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/setting.php', 'setting');
        $this->app['setting'] = $this->app->share(
            function ($app) {
                return new Setting(
                    $app['config']['setting.path']
                );
            }
        );
        // add Setting alias
        $this->app->booting(
            function ($app) {
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