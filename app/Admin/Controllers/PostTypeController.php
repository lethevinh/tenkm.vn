<?php

namespace App\Admin\Controllers;

use App\Admin\Forms\ToolViewLive;
use App\Admin\Repositories\Post;
use App\Models\Tag;
use Dcat\Admin\Form;
use Dcat\Admin\Form\NestedForm;
use Dcat\Admin\Grid;
use Dcat\Admin\Controllers\AdminController;
use Dcat\Admin\Layout\Content;
use Dcat\Admin\Models\Administrator as AdministratorModel;
use Dcat\Admin\Show;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class PostTypeController extends AdminController
{

    protected function getPostRepositoryClassName(): string
    {
        $type = request()->route('type', 'post');
        $class = "App\\Admin\\Repositories\\" . ucfirst($type);
        $classRepository = Post::class;
        if (class_exists($class)) {
            $classRepository = $class;
        }
        return $classRepository;
    }

    public function title()
    {
        $type = request()->route('type', 'post');
        return __('admin.') . $type;
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $type = request()->route('type', 'post');
        $widths = [];
        $relations = Str::plural($type);
//        $widths[] = $relations;
        $postRepositoryClassName = $this->getPostRepositoryClassName();
        return Grid::make(new $postRepositoryClassName(['categories', 'comments', 'creator']), function (Grid $grid) {
            $grid->model()->orderByDesc('updated_at');
            $grid->id('ID')->code()->sortable();
            $grid->actions(function (Grid\Displayers\Actions $actions) {
                $actions->disableView();
                $link = route('post.show', ['slug' => $actions->row['slug_lb']]);
                $actions->append('<a target="_blank" href="' . $link . '"><i class="feather icon-eye"></i>'.__('site.view_post').'</a>');
            });
            $grid->title_lb(__('admin.title'));
            $grid->comments(__('admin.comment'))->count()->label();
            $grid->categories(__('site.category'))->pluck('title_lb')->label('primary', 1);
            $grid->status_sl(__('site.status'))
                ->display(function ($value) {
                    return $value === 'public' ? 1 : 0;
                })
                ->switch();
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
                $categories = \App\Models\Category::where('type_lb', 'post')->has('posts')->get()->pluck('title_lb', 'id');
                $admins = AdministratorModel::all()->pluck('name', 'id');
                $filter->where('categories', function ($query) {
                    $value = $this->input;
                    $query->whereHas('categories', function (Builder $query) use ($value) {
                        $query->whereIn('category_id', $value);
                    });
                },__('site.category'))->width(5)->multipleSelect($categories);
                $filter->where('creator', function ($query) {
                    $value = $this->input;
                    $query->whereIn('created_by', $value);
                },__('admin.owner'))->width(3)->multipleSelect($admins);
                $filter->scope('new', __('site.today'))
                    ->whereDate('created_at', date('Y-m-d'))
                    ->orWhereDate('updated_at', date('Y-m-d'));
            });
            $grid->disableBatchDelete();
            $grid->showQuickEditButton();
            $grid->enableDialogCreate();
        });
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
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
    protected function form()
    {
        $postRepositoryClassName = $this->getPostRepositoryClassName();
        $form = new \App\Admin\Forms\Form(new $postRepositoryClassName(['categories', 'tags', 'comments']));
        $form->disableViewButton();
        $form->tools([ToolViewLive::make()]);
        $form->tab(__('admin.basic'), function (Form $form) {
            $form->text('title_lb', __('Title'));
            $form->datetimeRange('published_at', 'validated_at', __('site.public_time'));
            $form->switch('status_sl', __('site.status'))->customFormat(function ($value) {
                return $value === 'public' ? 1 : 0;
            })->saving(function ($value) {
                return $value === 1 ? 'public' : 'private' ;
            });
            $form->multipleSelect('categories', __('site.category'))
                ->options(function () {
                    return \App\Models\Category::ofType('post')->get()->pluck('title_lb', 'id');
                })
                ->customFormat(function ($v) {
                    return array_column($v, 'id');
                });
            $form->tags('tags', __('site.tag'))->options(function () {
                return Tag::ofType('post')->get()->pluck('title_lb', 'id');
            })->customFormat(function ($v) {
                return array_column($v, 'title_lb');
            });
        })->tab(__('admin.content'), function (Form $form) {
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
     * Edit interface.
     *
     * @param mixed $type
     * @param mixed $id
     * @param Content $content
     *
     * @return Content
     */

    public function editPost($type, $id, Content $content)
    {
//        $this->form()->setAction(url('/admin/post-type/service/' . $id));
        return $this->edit($id, $content);
    }

    /**
     * Show interface.
     *
     * @param mixed $type
     * @param mixed $id
     * @param Content $content
     *
     * @return Content
     */
    public function showPost($type, $id, Content $content)
    {
        return $this->show($id, $content);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param mixed $type
     * @param int $id
     *
     * @return Response
     */
    public function updatePost($type, $id)
    {
        return $this->update($id);
    }

    /**
     * Create interface.
     *
     * @param mixed $type
     * @param Content $content
     *
     * @return Content
     */
    public function createPost($type, Content $content)
    {
        return $this->create($content);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param mixed $type
     * @return mixed
     */
    public function storePost($type)
    {
        return $this->store();
    }

    public function destroyPost($type, $id)
    {
        return $this->destroy($id);
    }
}
