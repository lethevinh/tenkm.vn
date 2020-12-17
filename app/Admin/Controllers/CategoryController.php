<?php

namespace App\Admin\Controllers;

use App\Admin\Forms\ToolTranslatable;
use App\Admin\Forms\ToolViewLive;
use App\Admin\Repositories\PostCategory;
use App\Admin\Forms\Form;
use App\Models\Category;
use Dcat\Admin\Grid;
use Dcat\Admin\Controllers\AdminController;
use Dcat\Admin\Layout\Content;
use Dcat\Admin\Models\Administrator as AdministratorModel;
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
    protected function getCategoryModelClassName(): string
    {
        $type = request()->route('type', 'post');
        $class = "App\\Models\\" . ucfirst($type) . "Category";
        $classRepository = Category::class;
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
            $grid->actions(function (Grid\Displayers\Actions $actions) {
                $actions->disableView();
                $link = route('product.category', ['category' => $actions->row['slug_lb']]);
                $actions->append('<a target="_blank" href="' . $link . '"><i class="feather icon-eye"></i>' . __('site.view_post') . '</a>');
            });
            $grid->model()->orderByDesc('updated_at');
            $grid->column('title_lb', __('admin.title'))->sortable();
            $grid->column('slug_lb', __('site.link'))
                ->display(function ($slug) {
                    return route('product.category', ['category' => $slug]);
                })->copyable();
            if ($relations !== '') {
                $grid->{$relations}->count()->label();
            }
            $grid->status_sl(__('site.status'))
                ->display(function ($value) {
                    return $value === 'public' ? 1 : 0;
                })
                ->switch();
            $grid->language_lb(__('site.lang'))->label();
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
                }, __('admin.owner'))->width(3)->multipleSelect($admins);
                $filter->scope('new', __('site.today'))
                    ->whereDate('created_at', date('Y-m-d'))
                    ->orWhereDate('updated_at', date('Y-m-d'));
                foreach (config('site.locales') as $locale) {
                    $filter->scope('lang_' . $locale, __('site.' . $locale))
                        ->where('language_lb', $locale);
                }
            });
            //$grid->disableBatchDelete();
            $grid->showQuickEditButton();
            //$grid->enableDialogCreate();
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
        $id = request()->route('id');
        $form = new Form(new $classRepository());
        $classMode = $this->getCategoryModelClassName();
        $model = $form->getModel();
        if (!$model){
            $model = new $classMode();
        }
        if ($id) {
            $model = $model->find($id);
        }
        $language = $model && $model->id ? $model->language_lb : config('site.locale_default');
        $form->tools([ToolViewLive::make(), ToolTranslatable::make()]);
        $form->display('id', __('ID'));
        $form->text('title_lb', __('Title'));
        $form->text('slug_lb', __('Slug'));
        $form->hidden('language_lb')->default(config('site.locale_default'));
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
            ->options($model->selectOptions($language));
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
