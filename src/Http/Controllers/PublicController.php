<?php

namespace TypiCMS\Modules\Categories\Http\Controllers;

use TypiCMS\Modules\Categories\Repositories\EloquentCategory;
use TypiCMS\Modules\Core\Http\Controllers\BasePublicController;

class PublicController extends BasePublicController
{
    public function __construct(EloquentCategory $category)
    {
        parent::__construct($category);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $models = $this->repository->published()->findAll();

        return view('categories::public.index')
            ->with(compact('models'));
    }

    /**
     * Show resource.
     *
     * @return \Illuminate\Support\Facades\Response
     */
    public function show($category = null, $slug = null)
    {
        $model = $this->repository->published()->bySlug($slug);

        return view('categories::public.show')
            ->with(compact('model'));
    }
}
