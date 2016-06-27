<?php

namespace Minhbang\Setting;

use Illuminate\Routing\Router;
use Minhbang\Kit\Extensions\BaseServiceProvider;
use Illuminate\Foundation\AliasLoader;
use MenuManager;

/**
 * Class ServiceProvider
 *
 * @package Minhbang\Setting
 */
class ServiceProvider extends BaseServiceProvider
{
    /**
     * @param \Illuminate\Routing\Router $router
     */
    public function boot(Router $router)
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
        $this->mapWebRoutes($router, __DIR__ . '/routes.php', config('setting.add_route'));
        // Add setting menus
        MenuManager::addItems(config('setting.menus'));
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
            function () {
                return new Setting(
                    config('setting.path'),
                    config('setting.zones')
                );
            }
        );
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