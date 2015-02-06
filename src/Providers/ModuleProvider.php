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
use TypiCMS\Modules\Categories\Services\Form\CategoryForm;
use TypiCMS\Modules\Categories\Services\Form\CategoryFormLaravelValidator;
use TypiCMS\Observers\FileObserver;
use TypiCMS\Observers\SlugObserver;
use TypiCMS\Services\Cache\LaravelCache;
use View;

class ModuleProvider extends ServiceProvider
{

    public function boot()
    {
        // Bring in the routes
        require __DIR__ . '/../routes.php';

        // Add dirs
        View::addNamespace('categories', __DIR__ . '/../views/');
        $this->loadTranslationsFrom(__DIR__ . '/../lang', 'categories');
        $this->publishes([
            __DIR__ . '/../config/' => config_path('typicms/categories'),
        ], 'config');
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

        $app->bind('TypiCMS\Modules\Categories\Services\Form\CategoryForm', function (Application $app) {
            return new CategoryForm(
                new CategoryFormLaravelValidator($app['validator']),
                $app->make('TypiCMS\Modules\Categories\Repositories\CategoryInterface')
            );
        });

    }
}
