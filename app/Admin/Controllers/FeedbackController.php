<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\Feedback;
use Dcat\Admin\Auth\Permission;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\IFrameGrid;
use Dcat\Admin\Controllers\AdminController;
use Dcat\Admin\Models\Administrator as AdministratorModel;
use Dcat\Admin\Show;
use Dcat\Admin\Support\Helper;
use Illuminate\Support\Carbon;


class FeedbackController extends AdminController
{

    protected function title()
    {
        return __('site.feedback');
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new Feedback(['creator']), function (Grid $grid) {
            $grid->model()->orderByDesc('updated_at');
            $grid->id('ID')->code()->sortable();
            $grid->title_lb(__('admin.title'));
            $grid->owner_lb(__('site.owner'));
            $grid->creator(__('admin.owner'))->display(function($creator) {
                return $creator['name'];
            })->label('warning');
            $grid->status_sl(__('site.status'))
                ->display(function ($value) {
                    return $value === 'public' ? 1 : 0;
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
                $filter->scope('new', __('admin.today'))
                    ->whereDate('created_at', date('Y-m-d'))
                    ->orWhereDate('updated_at', date('Y-m-d'));
            });
            $grid->disableBatchDelete();
            $grid->showQuickEditButton();
            $grid->enableDialogCreate();
        });
    }

    protected function iFrameGrid()
    {
        $grid = new IFrameGrid(new Feedback());

        $grid->rowSelector()->titleColumn('title_lb');

        $grid->id->sortable();
        $grid->title_lb;

        $grid->filter(function (Grid\Filter $filter) {
            $filter->equal('id');
            $filter->like('title_lb');
        });

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
        return Show::make($id, new Feedback(), function (Show $show) {
            $show->id;
            $show->title_lb(__('admin.title'));
            $show->description_lb(__('admin.description'));
            $show->content_lb(__('admin.content'))->unescape();
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
        $form = new Form(new Feedback());
        $form->text('title_lb', __('site.subject'));
        $form->text('owner_lb', __('site.name'));
        $form->switch('status_sl', __('site.status'))->customFormat(function ($value) {
            return $value === 'public' ? 1 : 0;
        })->saving(function ($value) {
            return $value === 1 ? 'public' : 'private' ;
        });
        $form->textarea('content_lb', __('site.body'));
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
        if (in_array(AdministratorModel::DEFAULT_ID, Helper::array($id))) {
            Permission::error();
        }

        return parent::destroy($id);
    }
}
