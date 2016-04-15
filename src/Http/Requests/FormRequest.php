<?php

namespace TypiCMS\Modules\Categories\Http\Requests;

use TypiCMS\Modules\Core\Http\Requests\AbstractFormRequest;

class FormRequest extends AbstractFormRequest
{
    public function rules()
    {
        return [
            'image'   => 'image|max:2000',
            'title.*' => 'max:255',
            'slug.*'  => 'alpha_dash|max:255',
        ];
    }
}
