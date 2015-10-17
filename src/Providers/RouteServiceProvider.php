<?php

namespace TypiCMS\Modules\Categories\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Request;

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
     * @return void
     */
    public function boot(Router $router)
    {
        parent::boot($router);

        if (Request::segment(1) != 'admin' && Request::segment(1) != 'api') {
            $router->bind('categories', function ($slug) {
                $repository = app('TypiCMS\Modules\Categories\Repositories\CategoryInterface');

                return $repository->bySlug($slug);
            });
        } else {
            $router->model('categories', 'TypiCMS\Modules\Categories\Models\Category');
        }
    }

    /**
     * Define the routes for the application.
     *
     * @param \Illuminate\Routing\Router $router
     *
     * @return void
     */
    public function map(Router $router)
    {
        $router->group(['namespace' => $this->namespace], function (Router $router) {
            /*
             * Admin routes
             */
            $router->resource('admin/categories', 'AdminController');
            $router->post('admin/categories/sort', ['as' => 'admin.categories.sort', 'uses' => 'AdminController@sort']);

            /*
             * API routes
             */
            $router->resource('api/categories', 'ApiController');
        });
    }
}
