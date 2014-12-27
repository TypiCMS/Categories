<?php
if (Request::segment(1) != 'admin' && Request::segment(1) != 'api') {

    Route::bind('categories', function ($value) {
        $query = TypiCMS\Modules\Categories\Models\Category::select('categories.id AS id', 'slug', 'locale', 'status')
            ->join('category_translations', 'categories.id', '=', 'category_translations.category_id')
            ->where('slug', $value)
            ->where('locale', App::getLocale());
        if (! Input::get('preview')) {
            $query->where('status', 1);
        }
        return $query->firstOrFail();
    });

} else {

    Route::bind('categories', function ($value) {
        return TypiCMS\Modules\Categories\Models\Category::where('id', $value)
            ->with('translations')
            ->firstOrFail();
    });

}

Route::group(
    array(
        'namespace' => 'TypiCMS\Modules\Categories\Controllers',
        'prefix'    => 'admin',
    ),
    function () {
        Route::resource('categories', 'AdminController');
        Route::post('categories/sort', array('as' => 'admin.categories.sort', 'uses' => 'AdminController@sort'));
    }
);

Route::group(array('prefix'=>'api/v1'), function() {
    Route::resource(
        'categories',
        'TypiCMS\Modules\Categories\Controllers\ApiController'
    );
});
