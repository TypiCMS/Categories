<?php

namespace TypiCMS\Modules\Categories\Repositories;

use Illuminate\Database\Eloquent\Collection;
use TypiCMS\Modules\Categories\Models\Category;
use TypiCMS\Modules\Core\EloquentRepository;

class EloquentCategory extends EloquentRepository
{
    protected $repositoryId = 'categories';

    protected $model = Category::class;

    /**
     * Get all categories for select/option.
     *
     * @return array
     */
    public function allForSelect()
    {
        $categories = $this->make()
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
