<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\Menu;
use Dcat\Admin\Form;
use Dcat\Admin\Controllers\AdminController;
use Dcat\Admin\Layout\Column;
use Dcat\Admin\Layout\Content;
use Dcat\Admin\Layout\Row;
use Dcat\Admin\Tree;
use Dcat\Admin\Widgets\Box;

class MenuController extends AdminController
{

    /**
     * Get content title.
     *
     * @return string
     */
    public function title()
    {
        return trans('admin.menu');
    }

    /**
     * Index interface.
     *
     * @param Content $content
     *
     * @return Content
     */
    public function index(Content $content)
    {
        return $content
            ->title($this->title())
            ->description(trans('admin.list'))
            ->body(function (Row $row) {
                $row->column(7, $this->treeView()->render());

                $row->column(5, function (Column $column) {
                    $form = new \Dcat\Admin\Widgets\Form();
                    $form->action(admin_url('menus'));

                    $menuModel = \App\Models\Menu::class;

                    $form->select('parent_id', trans('admin.parent_id'))->options($menuModel::selectOptions());
                    $form->text('title_lb', trans('admin.title'))->required();
                    $form->icon('media_lb', trans('admin.icon'))->help($this->iconHelp());
                    $form->text('uri', trans('admin.uri'));
                    $form->hidden('_token')->default(csrf_token());

                    $form->width(9, 2);

                    $column->append(Box::make(trans('admin.new'), $form));
                });
            });
    }

    /**
     * @return \Dcat\Admin\Tree
     */
    protected function treeView()
    {
        $tree = new Tree(new Menu());
        $tree->disableCreateButton();
        $tree->disableQuickCreateButton();

        $tree->branch(function ($branch) {
            return "{$branch['id']} - {$branch['title_lb']}";
        });

        return $tree;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    public function form()
    {
        $menuModel = \App\Models\Menu::class;

        $form = new Form(new Menu());

        $form->tools(function (Form\Tools $tools) {
            $tools->disableView();
        });

        $form->display('id', 'ID');

        $form->select('parent_id', trans('admin.parent_id'))->options(function () use ($menuModel) {
            return $menuModel::selectOptions();
        });
        $form->text('title_lb', trans('admin.title'))->required();
        $form->icon('media_lb', trans('admin.icon'))->help($this->iconHelp());
        $form->text('url_lb', trans('admin.uri'));

        $form->display('created_at', trans('admin.created_at'));
        $form->display('updated_at', trans('admin.updated_at'));

        return $form;
    }

    /**
     * Help message for icon field.
     *
     * @return string
     */
    protected function iconHelp()
    {
        return 'For more icons please see <a href="http://fontawesome.io/icons/" target="_blank">http://fontawesome.io/icons/</a>';
    }
}
