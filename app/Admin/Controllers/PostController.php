<?php

namespace App\Admin\Controllers;

use App\Admin\Forms\ToolTranslatable;
use App\Admin\Forms\ToolViewLive;
use App\Models\Category;
use App\Admin\Repositories\Post;
use App\Models\PostTag;
use App\Models\PostCategory;
use App\Models\Tag;
use Dcat\Admin\Auth\Permission;
use App\Admin\Forms\Form;
use Dcat\Admin\Form\BlockForm;
use Dcat\Admin\Form\NestedForm;
use Dcat\Admin\Grid;
use Dcat\Admin\IFrameGrid;
use Dcat\Admin\Controllers\AdminController;
use Dcat\Admin\Layout\Content;
use Dcat\Admin\Layout\Row;
use Dcat\Admin\Models\Administrator as AdministratorModel;
use Dcat\Admin\Show;
use Dcat\Admin\Support\Helper;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Builder;

class PostController extends AdminController
{
    protected function getTypePost()
    {
        return request()->route('type', 'post');
    }

    protected function getPostRepositoryClassName(): string
    {
        $type = $this->getTypePost();
        $class = "App\\Admin\\Repositories\\" . ucfirst($type);
        $classRepository = Post::class;
        if (class_exists($class)) {
            $classRepository = $class;
        }
        return $classRepository;
    }

    protected function title()
    {
        return trans('site.post');
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $postRepositoryClassName = $this->getPostRepositoryClassName();
        return Grid::make(new $postRepositoryClassName(['categories', 'creator']), function (Grid $grid) {
            $grid->model()->orderByDesc('updated_at');
            $grid->id('ID')->code()->sortable();
            $grid->actions(function (Grid\Displayers\Actions $actions) {
                $actions->disableView();
                $link = route('post.show', ['slug' => $actions->row['slug_lb']]);
                $actions->append('<a target="_blank" href="' . $link . '"><i class="feather icon-eye"></i>' . __('site.view_post') . '</a>');
            });
            $grid->title_lb(__('admin.title'));
            $grid->categories(__('site.category'))->pluck('title_lb')->label('primary', 1);
            $grid->status_sl(__('site.status'))
                ->display(function ($value) {
                    return $value === 'public' ? 1 : 0;
                })
                ->switch();
            $grid->creator(__('admin.owner'))->display(function ($creator) {
                return $creator['name'];
            })->label('warning');
            $grid->language_lb(__('site.lang'))->label();
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
                $categories = Category::where('type_lb', 'post')->has('posts')->get()->pluck('title_lb', 'id');
                $admins = AdministratorModel::all()->pluck('name', 'id');
                $filter->where('categories', function ($query) {
                    $value = $this->input;
                    $query->whereHas('categories', function (Builder $query) use ($value) {
                        $query->whereIn('category_id', $value);
                    });
                }, __('site.category'))->width(5)->multipleSelect($categories);
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
            $grid->enableDialogCreate();
        });
    }

    /**
     * @return IFrameGrid
     */
    protected function iFrameGrid()
    {
        $postRepositoryClassName = $this->getPostRepositoryClassName();
        $grid = new IFrameGrid(new $postRepositoryClassName());
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
        $postRepositoryClassName = $this->getPostRepositoryClassName();
        return Show::make($id, new $postRepositoryClassName(), function (Show $show) {
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
        $postRepositoryClassName = $this->getPostRepositoryClassName();

        $form = new Form(new $postRepositoryClassName(['categories', 'tags', 'comments']));
        $form->disableViewButton();
        $form->tools([ToolViewLive::make(), ToolTranslatable::make()]);
        $model = false;
        if (!empty($id)) {
            $model = \App\Models\Product::find($id);
        }
        $language = $model ? $model->language_lb : config('site.locale_default');
        $form->tab(__('admin.basic'), function (Form $form) use ($language){
            $form->text('title_lb', __('admin.title'));
            $form->hidden('language_lb')->default(config('site.locale_default'));
            $form->datetimeRange('published_at', 'validated_at', __('site.public_time'));
            $form->switch('status_sl', __('site.status'))
                ->customFormat(function ($value) {
                    return $value === 'public' ? 1 : 0;
                })->saving(function ($value) {
                    return $value === 1 ? 'public' : 'private';
                });
            $form->multipleSelect('categories', __('site.category'))
                ->options(function () use ($language) {
                    return PostCategory::lang($language)->get()->pluck('title_lb', 'id');
                })
                ->customFormat(function ($v) {
                    return array_column($v, 'id');
                });
            $form->tags('tags', __('site.tag'))
                ->options(PostTag::lang($language)->get()->pluck('title_lb', 'id'))
                ->customFormat(function ($v) {
                    return array_column($v, 'title_lb');
                });
        })
            ->tab(__('admin.content'), function (Form $form) {
                $form->textarea('description_lb', __('admin.description'));
                $form->editor('content_lb', __('admin.content'));
                $form->media('image_lb', __('admin.avatar'))->image();
            });
        if ($form->isCreating()) {
            $form->tab(__('admin.comment'), function (Form $form) {
                $form->hasMany('comments', __('admin.comment'), function (NestedForm $form) {
                    $form->text('title_lb', __('admin.title'))->disable();
                    $form->textarea('body_lb', __('admin.content'))->disable();
                    $form->display('created_at', __('admin.created_at'))->disable();
                    $form->select('status_sl', __('admin.status'))->options(\App\Models\Post::STATUS);
                })->useTable()->disableHorizontal()->disableCreate();
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
        if (in_array(AdministratorModel::DEFAULT_ID, Helper::array($id))) {
            Permission::error();
        }

        return parent::destroy($id);
    }
}
