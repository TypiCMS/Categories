<?php

namespace TypiCMS\Modules\Categories\Providers;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Foundation\Application;
use Illuminate\Support\ServiceProvider;
use TypiCMS\Modules\Categories\Models\Category;
use TypiCMS\Modules\Categories\Repositories\EloquentCategory;
use TypiCMS\Modules\Core\Observers\FileObserver;
use TypiCMS\Modules\Core\Observers\SlugObserver;

class ModuleProvider extends ServiceProvider
{
    public function boot()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/config.php', 'typicms.categories'
        );

        $modules = $this->app['config']['typicms']['modules'];
        $this->app['config']->set('typicms.modules', array_merge(['categories' => []], $modules));

        $this->loadViewsFrom(__DIR__.'/../resources/views/', 'categories');
        $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'categories');

        $this->publishes([
            __DIR__.'/../resources/views' => base_path('resources/views/vendor/categories'),
        ], 'views');
        $this->publishes([
            __DIR__.'/../database' => base_path('database'),
        ], 'migrations');

        AliasLoader::getInstance()->alias(
            'Categories',
            'TypiCMS\Modules\Categories\Facades\Facade'
        );

        // Observers
        Category::observe(new SlugObserver());
        Category::observe(new FileObserver());
    }

    public function register()
    {
        $app = $this->app;

        /*
         * Register route service provider
         */
        $app->register('TypiCMS\Modules\Categories\Providers\RouteServiceProvider');

        /*
         * Sidebar view composer
         */
        $app->view->composer('core::admin._sidebar', 'TypiCMS\Modules\Categories\Composers\SidebarViewComposer');

        $app->bind('Categories', EloquentCategory::class);
    }
}
