<?php

namespace Modules\Port\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Factory;

class PortServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->registerViews();
        $this->registerConfig();
        $this->registerFactories();
        $this->registerTranslations();
        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');
        $modules = [];
        foreach (app('modules')->collections() as $name => $value) {
            $modules[] = module_data(mb_strtolower($name));
        }
        View::composer('*', function ($view) use ($modules) {
            $view->with('modules', $modules);
        });
    }

    public function provides()
    {
        return [];
    }

    public function register()
    {
        $this->app->register(RouteServiceProvider::class);
    }

    public function registerFactories()
    {
        if (!app()->environment('production')) {
            app(Factory::class)->load(__DIR__ . '/../Database/factories');
        }
    }

    public function registerTranslations()
    {
        $langPath = resource_path('lang/modules/port');
        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, 'port');
        } else {
            $this->loadJsonTranslationsFrom(__DIR__ . '/../Resources/lang');
            // $this->loadTranslationsFrom(__DIR__ . '/../Resources/lang', 'port');
        }
    }

    public function registerViews()
    {
        $sourcePath = __DIR__ . '/../Resources/views';
        $viewPath   = resource_path('views/modules/port');
        $this->publishes([$sourcePath => $viewPath], 'views');
        $this->loadViewsFrom(array_merge(array_map(function ($path) {
            return $path . '/modules/port';
        }, Config::get('view.paths')), [$sourcePath]), 'port');
    }

    protected function registerConfig()
    {
        $this->publishes([__DIR__ . '/../Config/config.php' => config_path('port.php'), ], 'config');
        $this->mergeConfigFrom(__DIR__ . '/../Config/config.php', 'port');
    }
}
