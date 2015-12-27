<?php

namespace TypiCMS\Modules\Categories\Repositories;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use TypiCMS\Modules\Core\Repositories\RepositoriesAbstract;

class EloquentCategory extends RepositoriesAbstract implements CategoryInterface
{
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * Get all categories for select/option.
     *
     * @return array
     */
    public function allForSelect()
    {
        $categories = $this->make(['translations'])
            ->online()
            ->order()
            ->get()
            ->pluck('title', 'id')
            ->all();

        return ['' => ''] + $categories;
    }

    /**
     * Get all categories and prepare for menu.
     *
     * @param string $uri
     *
     * @return Collection
     */
    public function allForMenu($uri = '')
    {
        $categories = $this->all();
        $categories->each(function ($category) use ($uri) {
            $category->url = $uri.'/'.$category->slug;
        });

        return $categories;
    }
}
