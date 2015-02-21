<?php
namespace TypiCMS\Modules\Categories\Providers;

use Config;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Foundation\Application;
use Illuminate\Support\ServiceProvider;
use Lang;
use TypiCMS\Modules\Categories\Models\Category;
use TypiCMS\Modules\Categories\Models\CategoryTranslation;
use TypiCMS\Modules\Categories\Repositories\CacheDecorator;
use TypiCMS\Modules\Categories\Repositories\EloquentCategory;
use TypiCMS\Observers\FileObserver;
use TypiCMS\Observers\SlugObserver;
use TypiCMS\Services\Cache\LaravelCache;
use View;

class ModuleProvider extends ServiceProvider
{

    public function boot()
    {

        $this->loadViewsFrom(__DIR__ . '/../resources/views/', 'categories');
        $this->publishes([
            __DIR__ . '/../views' => base_path('resources/views/vendor/categories'),
        ], 'views');
        $this->loadTranslationsFrom(__DIR__ . '/../resources/lang', 'categories');
        $this->mergeConfigFrom(
            __DIR__ . '/../config/config.php', 'typicms.categories'
        );
        $this->publishes([
            __DIR__ . '/../migrations/' => base_path('/database/migrations'),
        ], 'migrations');

        AliasLoader::getInstance()->alias(
            'Categories',
            'TypiCMS\Modules\Categories\Facades\Facade'
        );

        // Observers
        CategoryTranslation::observe(new SlugObserver);
        Category::observe(new FileObserver);
    }

    public function register()
    {

        $app = $this->app;

        /**
         * Register route service provider
         */
        $app->register('TypiCMS\Modules\Categories\Providers\RouteServiceProvider');

        /**
         * Sidebar view composer
         */
        $app->view->composer('core::admin._sidebar', 'TypiCMS\Modules\Categories\Composers\SideBarViewComposer');

        $app->bind('TypiCMS\Modules\Categories\Repositories\CategoryInterface', function (Application $app) {
            $repository = new EloquentCategory(new Category);
            if (! Config::get('app.cache')) {
                return $repository;
            }
            $laravelCache = new LaravelCache($app['cache'], 'categories', 10);

            return new CacheDecorator($repository, $laravelCache);
        });

    }
}
