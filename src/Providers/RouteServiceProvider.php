<?php

namespace TypiCMS\Modules\Categories\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Request;
use TypiCMS\Modules\Categories\Repositories\CategoryInterface;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to the controller routes in your routes file.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'TypiCMS\Modules\Categories\Http\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @param \Illuminate\Routing\Router $router
     *
     * @return null
     */
    public function boot(Router $router)
    {
        parent::boot($router);
        if (Request::segment(1) != 'admin' && Request::segment(1) != 'api') {
            $router->bind('category', function ($slug) {
                $repository = app(CategoryInterface::class);

                return $repository->bySlug($slug);
            });
        }
    }

    /**
     * Define the routes for the application.
     *
     * @param \Illuminate\Routing\Router $router
     *
     * @return null
     */
    public function map(Router $router)
    {
        $router->group(['namespace' => $this->namespace], function (Router $router) {
            /*
             * Admin routes
             */
            $router->get('admin/categories', 'AdminController@index')->name('admin::index-categories');
            $router->get('admin/categories/create', 'AdminController@create')->name('admin::create-category');
            $router->get('admin/categories/{category}/edit', 'AdminController@edit')->name('admin::edit-category');
            $router->post('admin/categories', 'AdminController@store')->name('admin::store-category');
            $router->put('admin/categories/{category}', 'AdminController@update')->name('admin::update-category');
            $router->post('admin/categories/sort', 'AdminController@sort')->name('admin::sort-categories');

            /*
             * API routes
             */
            $router->get('api/categories', 'ApiController@index')->name('api::index-categories');
            $router->put('api/categories/{category}', 'ApiController@update')->name('api::update-category');
            $router->delete('api/categories/{category}', 'ApiController@destroy')->name('api::destroy-category');
        });
    }
}
