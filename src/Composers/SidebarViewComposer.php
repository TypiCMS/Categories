<?php

namespace TypiCMS\Modules\Categories\Composers;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Gate;
use Maatwebsite\Sidebar\SidebarGroup;
use Maatwebsite\Sidebar\SidebarItem;

class SidebarViewComposer
{
    public function compose(View $view)
    {
        $view->sidebar->group(trans('global.menus.content'), function (SidebarGroup $group) {
            $group->addItem(trans('categories::global.name'), function (SidebarItem $item) {
                $item->icon = config('typicms.categories.sidebar.icon', 'icon fa fa-fw fa-list-ul');
                $item->weight = config('typicms.categories.sidebar.weight');
                $item->route('admin::index-categories');
                $item->append('admin::create-category');
                $item->authorize(
                    Gate::allows('index-categories')
                );
            });
        });
    }
}
