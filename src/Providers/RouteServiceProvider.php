<?php

namespace TypiCMS\Modules\Categories\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;

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
     * Define the routes for the application.
     *
     * @return null
     */
    public function map()
    {
        Route::group(['namespace' => $this->namespace], function (Router $router) {
            /*
             * Admin routes
             */
            $router->group(['middleware' => 'admin', 'prefix' => 'admin'], function (Router $router) {
                $router->get('categories', 'AdminController@index')->name('admin::index-categories');
                $router->get('categories/create', 'AdminController@create')->name('admin::create-category');
                $router->get('categories/{category}/edit', 'AdminController@edit')->name('admin::edit-category');
                $router->post('categories', 'AdminController@store')->name('admin::store-category');
                $router->put('categories/{category}', 'AdminController@update')->name('admin::update-category');
                $router->post('categories/sort', 'AdminController@sort')->name('admin::sort-categories');
                $router->patch('categories/{category}', 'AdminController@ajaxUpdate');
                $router->delete('categories/{category}', 'AdminController@destroy')->name('admin::destroy-category');
            });
        });
    }
}
