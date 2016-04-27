<?php

namespace TypiCMS\Modules\Categories\Models;

use Laracasts\Presenter\PresentableTrait;
use Spatie\Translatable\HasTranslations;
use TypiCMS\Modules\Core\Models\Base;
use TypiCMS\Modules\History\Traits\Historable;

class Category extends Base
{
    use HasTranslations;
    use Historable;
    use PresentableTrait;

    protected $presenter = 'TypiCMS\Modules\Categories\Presenters\ModulePresenter';

    protected $guarded = ['id', 'exit', 'galleries'];

    public $translatable = [
        'title',
        'slug',
        'status',
    ];

    protected $appends = ['thumb'];

    public $attachments = [
        'image',
    ];

    public function projects()
    {
        return $this->hasMany('TypiCMS\Modules\Projects\Models\Project')->order();
    }

    /**
     * Append thumb attribute.
     *
     * @return string
     */
    public function getThumbAttribute()
    {
        return $this->present()->thumbSrc(null, 22);
    }
}
