<?php
namespace TypiCMS\Modules\Categories\Composers;

use Illuminate\Contracts\View\View;
use Maatwebsite\Sidebar\SidebarGroup;
use Maatwebsite\Sidebar\SidebarItem;
use TypiCMS\Composers\BaseSidebarViewComposer;

class SidebarViewComposer extends BaseSidebarViewComposer
{
    public function compose(View $view)
    {
        $view->sidebar->group(trans('global.menus.content'), function (SidebarGroup $group) {
            $group->addItem(trans('categories::global.name'), function (SidebarItem $item) {
                $item->icon = config('typicms.categories.sidebar.icon', 'icon fa fa-fw fa-list-ul');
                $item->weight = config('typicms.categories.sidebar.weight');
                $item->route('admin.categories.index');
                $item->append('admin.categories.create');
                $item->authorize(
                    $this->auth->hasAccess('categories.index')
                );
            });
        });
    }
}
