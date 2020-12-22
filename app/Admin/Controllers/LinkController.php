<?php

namespace App\Admin\Controllers;

use App\Admin\Forms\ToolTranslatable;
use App\Admin\Forms\ToolViewLive;
use App\Admin\Repositories\Link;
use App\Models\Address;
use App\Models\Location;
use App\Models\ProductCategory;
use App\Models\Page;
use Dcat\Admin\Auth\Permission;
use App\Admin\Forms\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\IFrameGrid;
use Dcat\Admin\Controllers\AdminController;
use Dcat\Admin\Models\Administrator;
use Dcat\Admin\Models\Administrator as AdministratorModel;
use Dcat\Admin\Show;
use Dcat\Admin\Support\Helper;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;

class LinkController extends AdminController
{
    protected function title()
    {
        return __('site.links');
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new Link(['creator', 'contentable']), function (Grid $grid) {
            $grid->model()->orderBy('created_at', 'desc');
            $grid->id('ID')->code()->sortable();
            $grid->title_lb(__('admin.title'));
            $grid->contentable(__('admin.title'))->display(function ($value) {
                return isset($value['title_lb'])?$value['title_lb']:'' ;
            });
            $grid->status_sl(__('admin.status'))
                ->display(function ($value) {
                    return $value === 'public' ? 1 : 0;
                })
                ->status();
            $grid->language_lb(__('site.lang'))->label();
            $grid->column('slug_lb', __('site.link'))
                ->display(function ($slug) {
                    return route('link.show', ['slug' => $slug]);
                })->copyable();
            $grid->creator(__('admin.owner'))->display(function($creator) {
                return $creator['name'];
            })->label('warning');
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
            });
            //$grid->disableBatchDelete();
            $grid->showQuickEditButton();
            //$grid->enableDialogCreate();
        });
    }

    /**
     * @return IFrameGrid
     */
    protected function iFrameGrid()
    {
        $grid = new IFrameGrid(new Link());
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
        return Show::make($id, new Link(), function (Show $show) {
            $show->id;
            $show->title_lb(__('admin.title'));
            $show->description_lb(__('admin.description'));
            $show->content_lb(__('admin.content'))->unescape();
            $show->image_lb(__('admin.avatar'))->image();
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
        $form = new Form(new Link());
        $form->tools([ToolViewLive::make(), ToolTranslatable::make()]);
        $id = str_replace(['/admin/links/', '/edit'], '', request()->getRequestUri());
        $model = $form->getModel();
        if (!empty($id)) {
            $model = \App\Models\Link::find($id);
        }
        if (!$model){
            $model = new \App\Models\Link();
        }
        $form->text('title_lb', __('admin.title'));
        $form->text('slug_lb', __('admin.slug'))->rules(function ($form) {
            if (!$id = $form->model()->id) {
                return 'unique:links,slug_lb';
            }
        });
        $form->xSelect('template_lb', __('site.type'))->options(function(){
            return [
                'category' => tran('site.category'),
                'page' => tran('site.page'),
                'location' => tran('site.location'),
            ];
        })->customFormat(function($value) use ($model){
            switch ($model->contentable_type){
                case ProductCategory::class:
                    return 'category';
                case Page::class:
                    return 'page';
                case Address::class:
                    return 'location';
            }
        })->loads(['contentable'], ['api/contentable']);
        $form->xSelect('contentable', __('site.content'))
            ->customFormat(function ($v) use ($model){
                return $model->contentable && $model->contentable->id? $model->contentable->id:'';
            });
        $form->hidden('language_lb')->default(config('site.locale_default'));
        $form->switch('status_sl', __('site.status'))->customFormat(function ($value) {
            return $value === 'public' ? 1 : 0;
        })->saving(function ($value) {
            return $value === 1 ? 'public' : 'private' ;
        })->value(1);
        $form->disableViewCheck();
        $form->submitted(function (Form $form) use ($model){
            if ($model->id && $form->input('contentable')) {
                $id = $form->input('contentable');
                $type = $form->input('template_lb');
                $linkable = false;
                switch ($type) {
                    case 'category':
                        $linkable = ProductCategory::find($id);
                        break;
                    case 'page':
                        $linkable = Page::find($id);
                        break;
                    case 'location':
                        $linkable = Address::find($id);
                        break;
                }
                if ($linkable && $linkable->id) {
                    $linkable->link()->save($model);
                }
            }
            $form->ignore(['contentable']);
        });
        $form->saved(function (Form $form) {
            $model = $form->getModel();
            $request = request();
            if ($model->id && $request->input('contentable')) {
                $id = $request->input('contentable');
                $type = $request->input('template_lb');
                $linkable = false;
                switch ($type) {
                    case 'category':
                        $linkable = ProductCategory::find($id);
                        break;
                    case 'page':
                        $linkable = Page::find($id);
                        break;
                    case 'location':
                        $linkable = Address::find($id);
                        break;
                }
                if ($linkable && $linkable->id) {
                    $linkable->link()->save($model);
                }
            }
        });
        return $form;
    }
}