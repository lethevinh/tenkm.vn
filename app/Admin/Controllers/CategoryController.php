<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\Category;
use App\Admin\Repositories\Post;
use App\Admin\Repositories\PostCategory;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Controllers\AdminController;
use Dcat\Admin\Layout\Content;
use Dcat\Admin\Show;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class CategoryController extends AdminController
{

    protected function getCategoryRepositoryClassName(): string
    {
        $type = request()->route('type', 'post');
        $class = "App\\Admin\\Repositories\\" . ucfirst($type) . "Category";
        $classRepository = PostCategory::class;
        if (class_exists($class)) {
            $classRepository = $class;
        }
        return $classRepository;
    }

    public function title()
    {
        $type = request()->route('type', 'post');
        return __('site.category') . ' ' . $type;
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
        $widths[] = $relations;
        $classRepository =  $this->getCategoryRepositoryClassName();
        return Grid::make(new $classRepository($widths), function (Grid $grid) use ($relations) {
            $grid->model()->orderByDesc('updated_at');
            $grid->column('id', __('ID'))->sortable();
            $grid->column('title_lb', __('Title'))->sortable();
            if ($relations !== '') {
                $grid->{$relations}->count()->label();
            }
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
        $classRepository =  $this->getCategoryRepositoryClassName();
        return Show::make($id, new $classRepository(), function (Show $show) use ($id) {
            $show->field('id', __('ID'));
            $show->field('title_lb', __(__('admin.title')));
            $show->field('description_lb', __(__('admin.description')));
            $show->field('content_lb', __(__('admin.content')))->unescape();
            $show->field('created_at', __('Created at'));
            $show->field('updated_at', __('Updated at'));
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $classRepository =  $this->getCategoryRepositoryClassName();

        $type = request()->route('type', 'post');
        $form = new Form(new $classRepository());

        $form->display('id', __('ID'));
        $form->text('title_lb', __('Title'));
        $form->textarea('description_lb', __('Description'));
        $form->editor('content_lb', __('Content'));
        $form->image('image_lb', __('Image'));
        $form->hidden('type_lb', __('Type'))->value($type);
        $form->switch('status_sl', __('site.status'))->customFormat(function ($value) {
            return $value === 'public' ? 1 : 0;
        })->saving(function ($value) {
            return $value === 1 ? 'public' : 'private';
        });

        $form->select('parent_id', 'Parent')
            ->options(\App\Models\Category::where('type_lb', $type)->get()->pluck('title_lb', 'id'));
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
