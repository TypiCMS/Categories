<?php
namespace TypiCMS\Modules\Categories\Http\Controllers;

use Illuminate\Support\Str;
use View;
use TypiCMS\Http\Controllers\BasePublicController;
use TypiCMS\Modules\Categories\Repositories\CategoryInterface;

class PublicController extends BasePublicController
{

    public function __construct(CategoryInterface $category)
    {
        parent::__construct($category);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $models = $this->repository->all();
        return view('categories::public.index')
            ->with(compact('models'));
    }

    /**
     * Show resource.
     *
     * @return Response
     */
    public function show($category = null, $slug = null)
    {
        $model = $this->repository->bySlug($slug);
        return view('categories::public.show')
            ->with(compact('model'));
    }
}
