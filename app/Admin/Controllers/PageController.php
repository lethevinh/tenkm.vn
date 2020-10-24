<?php

namespace App\Admin\Controllers;

use App\Admin\Forms\ToolTranslatable;
use App\Admin\Forms\ToolViewLive;
use App\Admin\Repositories\Page;
use Dcat\Admin\Admin;
use Dcat\Admin\Auth\Permission;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\IFrameGrid;
use Dcat\Admin\Controllers\AdminController;
use Dcat\Admin\Layout\Content;
use Dcat\Admin\Models\Administrator;
use Dcat\Admin\Models\Administrator as AdministratorModel;
use Dcat\Admin\Show;
use Dcat\Admin\Support\Helper;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;

class PageController extends AdminController
{
    protected function title()
    {
        return __('site.page');
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new Page(['creator']), function (Grid $grid) {
            $grid->model()->private()->orderByDesc('updated_at');
            $grid->id('ID')->code()->sortable();
            $grid->actions(function (Grid\Displayers\Actions $actions) {
                $actions->disableView();
                $link = route('page.show', ['slug' => $actions->row['slug_lb']]);
                $actions->prepend('<a target="_blank" href="' . $link . '"><i class="feather icon-eye"></i>' . __('site.view_post') . '</a>');
            });
            $grid->title_lb(__('admin.title'));
            $grid->status_sl(__('admin.status'))
                ->display(function ($value) {
                    return $value === 'public' ? 1 : 0;
                })
                ->status();
            $grid->creator(__('admin.owner'))->display(function ($creator) {
                return $creator['name'];
            })->label('warning');
            $grid->created_at(__('admin.created_at'))->display(function ($at) {
                return Carbon::make($at)->diffForHumans();
            });
            $grid->updated_at(__('admin.updated_at'))->sortable()->display(function ($at) {
                return Carbon::make($at)->diffForHumans();
            });
            $grid->language_lb(__('site.lang'))->label();

            $grid->quickSearch(['id', 'title_lb']);
            $grid->filter(function (Grid\Filter $filter) {
                $filter->panel();
                $filter->like('title_lb', __('admin.title'))->width(3);
                $admins = AdministratorModel::all()->pluck('name', 'id');
                $filter->where('creator', function ($query) {
                    $value = $this->input;
                    $query->whereIn('created_by', $value);
                }, __('admin.owner'))->width(3)->multipleSelect($admins);
                $filter->scope('new', __('site.today'))
                    ->whereDate('created_at', date('Y-m-d'))
                    ->orWhereDate('updated_at', date('Y-m-d'));
                foreach (config('site.locales') as $locale) {
                    $filter->scope('lang_' . $locale, __('site.' . $locale))
                        ->where('language_lb', $locale);
                }
            });
            $grid->disableBatchDelete();
            $grid->showQuickEditButton();
        });
    }

    /**
     * @return IFrameGrid
     */
    protected function iFrameGrid()
    {
        $grid = new IFrameGrid(new Page());
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
        return Show::make($id, new Page(), function (Show $show) {
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
        $form = new \App\Admin\Forms\Form(new Page(['metas', 'fields']));
        $form->disableViewButton();
        $form->tools([ToolViewLive::make(), ToolTranslatable::make()]);
        $form->hidden('language_lb')->default(config('site.locale_default'));
        $admin = Admin::user();
        $form->tab(__('site.content'), function (Form $form) use ($admin) {
            $form->text('title_lb', __('admin.title'));
            $form->switch('status_sl', __('site.status'))
                ->customFormat(function ($value) {
                return $value === 'public' ? 1 : 0;
            })
                ->saving(function ($value) {
                return $value === 1 ? 'public' : 'private';
            });
            $pageId = request()->route()->parameter('page');
            if ($pageId) {
                $page = \App\Models\Page::findOrFail($pageId);
                foreach ($page->fields as $field) {
                    $form->meta($field->name_lb, $field->label_lb)
                        ->type($field->type_lb)
                        ->default($field->default_lb);
                }
            }
            if ($admin->id === Administrator::DEFAULT_ID) {
                $form->text('template_lb', __('site.template'))->default('default');
            }
        })
            ->tab(__('site.basic'), function (Form $form) {
                $form->textarea('description_lb', __('admin.description'));
                $form->image('image_lb', __('admin.avatar'));
                $form->editor('content_lb', __('site.content'));
                $form->hidden('status_sl')->value('public');
            })->tab(__('site.seo'), function (Form $form) {
                $form->meta('seo_keyword', __('site.seo_keyword'));
                $form->meta('seo_description', __('site.seo_description'))->type('textarea');
            });

        if ($admin->id === Administrator::DEFAULT_ID) {
            $form->tab(__('site.field_manage'), function (Form $form) {
                $form->hasMany('fields', __(''), function (Form\NestedForm $form) {
                    $form->text('name_lb', __('admin.scaffold.key'))->required();
                    $form->text('label_lb', __('label'));
                    $form->text('default_lb', __('admin.default'));
                    $form->number('order_nb', __('admin.order'));
                    $form->select('type_lb', __('admin.type'))->options([
                        'text' => 'Text',
                        'media_image' => 'Media Image',
                        'media_images' => 'Media Images',
                        'media_file' => 'Media File',
                        'media_files' => 'Media Files',
                        'media_video' => 'Media Video',
                        'media_videos' => 'Media Videos',
                        'image' => 'Image',
                        'file' => 'File',
                        'textarea' => 'Textarea',
                        'time' => 'Time',
                        'datetime' => 'Datetime',
                        'date' => 'Date',
                        'email' => 'Email',
                        'html' => 'Html',
                        'icon' => 'Icon',
                        'select_category_post' => 'Select Category Post',
                        'select_categories_post' => 'Select Categories Post',
                        'select_post' => 'Select Post',
                        'select_posts' => 'Select Posts',
                        'select_page' => 'Select Page',
                        'select_pages' => 'Select Pages',
                        'select_user' => 'Select User',
                        'select_users' => 'Select Users',
                    ])->default('text')->required();
                });
            });
        }
        return $form;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        if (in_array(AdministratorModel::DEFAULT_ID, Helper::array($id)) && $id == 1) {
            Permission::error();
        }

        return parent::destroy($id);
    }

    /**
     * Model-form for user setting.
     *
     * @return Form
     */
    protected function settingForm()
    {
        $form = new \App\Admin\Forms\Form(new Page());

        $form->action(admin_url('site/setting'));

        $form->disableCreatingCheck();
        $form->disableEditingCheck();
        $form->disableViewCheck();

        $form->tools(function (Form\Tools $tools) {
            $tools->disableView();
            $tools->disableDelete();
        });

        $form->text('title_lb', trans('site.name'));
        $page = \App\Models\Page::site();
        if ($page) {
            foreach ($page->fields as $field) {
                $form->meta($field->name_lb, $field->label_lb)
                    ->type($field->type_lb)
                    ->default($field->default_lb);
            }
        }
        $form->saved(function (Form $form) {
            return $form->redirect(
                admin_url('site/setting'),
                trans('admin.update_succeeded')
            );
        });

        return $form;
    }

    /**
     * Site setting page.
     *
     * @param Content $content
     *
     * @return Content
     */
    public function getSetting(Content $content)
    {
        $form = $this->settingForm();
        $form->tools(
            function (Form\Tools $tools) {
                $tools->disableList();
            }
        );

        return $content
            ->title(trans('site.site_setting'))
            ->body($form->edit(Admin::user()->getKey()));
    }

    /**
     * Update site setting.
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function putSetting()
    {
        $form = $this->settingForm();
        return $form->update(\App\Models\Page::site()->getKey());
    }
}
