<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\Contact;
use Dcat\Admin\Auth\Permission;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\IFrameGrid;
use Dcat\Admin\Controllers\AdminController;
use Dcat\Admin\Models\Administrator as AdministratorModel;
use Dcat\Admin\Show;
use Dcat\Admin\Support\Helper;
use Illuminate\Support\Carbon;

class ContactController extends AdminController
{
    protected function title()
    {
        return __('site.contact');
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new Contact(), function (Grid $grid) {
            $grid->model()->orderByDesc('updated_at');
            $grid->title_lb(__('Type'))->sortable();
            $grid->column('name_lb', __('admin.name'))->sortable();
            $grid->column('email_lb', __('admin.email'));
            $grid->status_sl(__('site.watched'))
                ->display(function ($value) {
                    return $value === 'watched' ? 1 : 0;
                })
                ->switch();
            $grid->created_at(__('admin.created_at'))->display(function ($at) {
                return Carbon::make($at)->diffForHumans();
            });
            $grid->updated_at(__('admin.updated_at'))->sortable()->display(function ($at) {
                return Carbon::make($at)->diffForHumans();
            });

            $grid->quickSearch(['id', 'title_lb']);
            $grid->filter(function (Grid\Filter $filter) {
                $filter->panel();
                $filter->like('title_lb', __('admin.title'))->width(3);
                $admins = AdministratorModel::all()->pluck('name', 'id');
                $filter->where('creator', function ($query) {
                    $value = $this->input;
                    $query->whereIn('created_by', $value);
                },__('admin.owner'))->width(3)->multipleSelect($admins);
                $filter->scope('new', __('site.today'))
                    ->whereDate('created_at', date('Y-m-d'))
                    ->orWhereDate('updated_at', date('Y-m-d'));
                $filter->scope('type_register', __('Register'))->where('title_lb', 'register');
                $filter->scope('type_subscribe', __('Subscribe'))->where('title_lb', 'subscribe');
                $filter->scope('type_contact', __('Contact'))->where('title_lb', 'contact');
            });
            $grid->disableCreateButton();
            $grid->showBatchDelete();
        });
    }

    /**
     * @return IFrameGrid
     */
    protected function iFrameGrid()
    {
        $grid = new IFrameGrid(new Contact());
        $grid->quickSearch(['id', 'title_lb']);
        $grid->id->sortable();
        $grid->title_lb;
        $grid->created_at;

        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     *
     * @return Show
     */
    protected function detail($id)
    {
        return Show::make($id, new Contact(), function (Show $show) {
            $show->id;
            $show->title_lb(__('admin.title'));
            $show->field('name_lb', __('Name'));
            $show->field('email_lb', __('Email'));
            $show->created_at(__('admin.created_at'));
            $show->updated_at(__('admin.updated_at'));
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    public function form()
    {
        $form = new Form(new Contact);
        $form->text('title_lb', __('admin.title'));
        $form->switch('status_sl', __('site.watched'))->customFormat(function ($value) {
            return $value === 'public' ? 1 : 0;
        })->saving(function ($value) {
            return $value === 1 ? 'watched' : 'new' ;
        });
        $form->text('name_lb', __('admin.name'));
        $form->email('email_lb', __('admin.email'));
        $form->textarea('content_lb', __('admin.content'));
        return $form;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return parent::destroy($id);
    }
}
