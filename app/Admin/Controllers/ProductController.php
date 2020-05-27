<?php

namespace App\Admin\Controllers;

use App\Admin\Forms\ToolViewLive;
use App\Admin\Repositories\Product;
use App\Models\Location;
use App\Models\ProductCategory;
use App\Models\Category;
use App\Admin\Repositories\Post;
use App\Models\ProductTag;
use App\Models\Tag;
use Dcat\Admin\Auth\Permission;
use App\Admin\Forms\Form;
use Dcat\Admin\Form\NestedForm;
use Dcat\Admin\Grid;
use Dcat\Admin\IFrameGrid;
use Dcat\Admin\Controllers\AdminController;
use Dcat\Admin\Models\Administrator as AdministratorModel;
use Dcat\Admin\Show;
use Dcat\Admin\Support\Helper;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Builder;

class ProductController extends AdminController
{

    protected function getRepositoryClassName(): string
    {
        return Product::class;
    }

    protected function title()
    {
        return trans('site.product');
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $repositoryClassName = $this->getRepositoryClassName();
        return Grid::make(new $repositoryClassName(['categories', 'comments', 'creator']), function (Grid $grid) {
            $grid->model()->orderByDesc('updated_at');
            $grid->id('ID')->code()->sortable();
            $grid->actions(function (Grid\Displayers\Actions $actions) {
                $actions->disableView();
                $link = route('post.show', ['slug' => $actions->row['slug_lb']]);
                $actions->append('<a target="_blank" href="' . $link . '"><i class="feather icon-eye"></i>' . __('site.view_post') . '</a>');
            });
            $grid->title_lb(__('admin.title'));
            $grid->comments(__('admin.comment'))->count()->label();
            $grid->categories(__('site.category'))->pluck('title_lb')->label('primary', 1);
            $grid->status_sl(__('site.status'))
                ->display(function ($value) {
                    return $value === 'public' ? 1 : 0;
                })
                ->switch();
            $grid->creator(__('admin.owner'))->display(function ($creator) {
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
                $filter->scope('new', __('admin.today'))
                    ->whereDate('created_at', date('Y-m-d'))
                    ->orWhereDate('updated_at', date('Y-m-d'));
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
        $repositoryClassName = $this->getRepositoryClassName();
        $grid = new IFrameGrid(new $repositoryClassName());
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
        $repositoryClassName = $this->getRepositoryClassName();
        return Show::make($id, new $repositoryClassName(), function (Show $show) {
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
        $repositoryClassName = $this->getRepositoryClassName();
        $form = new Form(new $repositoryClassName(['categories', 'tags', 'comments', 'locations']));
        $form->disableViewButton();
        $form->tools([ToolViewLive::make()]);
        $form
            ->tab(__('site.basic'), function (Form $form) {
                $form->text('title_lb', __('admin.title'));
                $form->media('image_lb', __('admin.avatar'))->image();
                $form->media('gallery_lb', __('site.gallery'))->image()->multiple();
                $form->datetimeRange('published_at', 'validated_at', __('site.public_time'));
                $form->switch('status_sl', __('site.status'))->customFormat(function ($value) {
                    return $value === 'public' ? 1 : 0;
                })->saving(function ($value) {
                    return $value === 1 ? 'public' : 'private';
                });
                $form->select('categories', __('site.category'))
                    ->options(function () {
                        return ProductCategory::whereNotNull('parent_id')->get()->pluck('title_lb', 'id');
                    })
                    ->customFormat(function ($v) {
                        return array_column($v, 'id');
                    });
                $form->tags('tags', __('site.tag'))->options(function () {
                    return ProductTag::all()->pluck('title_lb', 'id');
                })->customFormat(function ($v) {
                    return array_column($v, 'title_lb');
                });
            })
            ->tab(__('site.location'), function (Form $form) {

                $form->select('provincial', __('site.provincial'))
                    ->options(function () {
                        return Location::ofType('provincial')->get()->pluck('title_lb', 'id');
                    })
                    ->customFormat(function ($v) {
                        if (!$v) return '';
                        return array_column($v, 'id');
                    })
                    ->load('district', 'api/locations');

                $form->select('district', __('site.district'))
                    ->load('ward', 'api/locations');

                $form->select('ward', __('site.ward'));

                $form->text('address_lb', __('site.address'));
                $form->map('location_lb', 'lng_lb', __('site.location'))
                    ->customFormat(function ($value) {
                        $location = explode(',', $value['lat']);
                        return [
                            'lat' => $location[0],
                            'lng' => $location[1],
                        ];
                    })
                    ->default('10.7553411,106.4150279');
            })
            ->tab(__('site.content'), function (Form $form) {
                $form->textarea('description_lb', __('admin.description'));
                $form->editor('content_lb', __('admin.content'));
                $form->media('image_lb', __('admin.avatar'))->image();
            });
        if ($form->isCreating()) {
            $form->tab(__('site.comment'), function (Form $form) {
                $form->hasMany('comments', '', function (NestedForm $form) {
                    $form->text('title_lb', __('admin.title'))->disable();
                    $form->textarea('body_lb', __('admin.content'))->disable();
                    $form->display('created_at', __('admin.created_at'))->disable();
                    $form->select('status_sl', __('admin.status'))->options(\App\Models\Post::STATUS);
                })->useTable()->disableHorizontal()->disableCreate()->width(10, 0);
            });
        }
        $form->submitted(function (Form $form) {
            $form->location_lb = $form->location_lb . ',' . $form->lng_lb;
            $form->ignore(['lng_lb']);
        });
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
