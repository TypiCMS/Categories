<?php
namespace TypiCMS\Modules\Categories\Composers;

use Illuminate\View\View;

class SidebarViewComposer
{
    public function compose(View $view)
    {
        $view->menus['content']->put('categories', [
            'weight' => config('typicms.categories.sidebar.weight'),
            'request' => $view->prefix . '/categories*',
            'route' => 'admin.categories.index',
            'icon-class' => 'icon fa fa-fw fa-list-ul',
            'title' => 'Categories',
        ]);
    }
}
