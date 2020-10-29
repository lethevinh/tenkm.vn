<?php

namespace App\Admin\Controllers;

use App\Admin\Forms\ToolTranslatable;
use App\Admin\Forms\ToolViewLive;
use App\Admin\Repositories\Project;
use App\Models\Amenity;
use App\Models\Category;
use App\Models\ProjectCategory;
use App\Models\ProjectTag;
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

class ProjectController extends AdminController
{

    protected function getRepositoryClassName(): string
    {
        return Project::class;
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
        $form = new Form(new $repositoryClassName(['categories', 'tags', 'comments', 'locations', 'amenities', 'address']));
        $form->disableViewButton();
        $form->tools([ToolViewLive::make(), ToolTranslatable::make()]);

        $form
            ->tab(__('site.basic'), function (Form $form) {
                $form->text('title_lb', __('admin.title'));
                $form->datetimeRange('published_at', 'validated_at', __('site.public_time'));
                $form->hidden('language_lb')->default(config('site.locale_default'));
                $form->switch('status_sl', __('site.status'))->customFormat(function ($value) {
                    return $value === 'public' ? 1 : 0;
                })->saving(function ($value) {
                    return $value === 1 ? 'public' : 'private';
                });
                $form->select('categories', __('site.category'))
                    ->options(function () use($form) {
                        $model = $form->getModel();
                        $language = $model ? $model->language_lb : config('site.locale_default');
                        return ProjectCategory::lang($language)->get()->pluck('title_lb', 'id');
                    })
                    ->customFormat(function ($v) {
                        if (!$v) return '';
                        return array_column($v, 'id')[0];
                    });
                $model = $form->getModel();
                $language = $model ? $model->language_lb : config('site.locale_default');
                $form->tags('tags', __('site.tag'))
                    ->options(ProjectTag::lang($language)->get()->pluck('title_lb', 'id'))
                    ->customFormat(function ($v) {
                        return array_column($v, 'title_lb');
                    });
                $form->checkbox('amenities',  __('site.amenity'))
                    ->options(Amenity::ofType('amenity')->get()->pluck('title_lb', 'id'))
                    ->customFormat(function ($v) {
                        return array_column($v, 'id');
                    });
            })
            ->tab(__('site.info'), function (Form $form) {
                $form->currency('price_fl', __('site.price'))->symbol('VND')
                    ->saving(function ($value) {
                        if (!$value) return 0;
                        return  str_replace(',', '', $value );
                    });
                $form->currency('price_sale_fl', __('site.price_sale'))
                    ->symbol('VND')
                    ->saving(function ($value) {
                        if (!$value) return 0;
                        return  str_replace(',', '', $value );
                    });
                $form->number('bedroom_nb', __('site.bedroom'));
                $form->number('bathroom_nb', __('site.bathroom'));
                $form->number('area_nb', __('site.area'));
            })
            ->tab(__('site.media'), function (Form $form) {
                $form->media('image_lb', __('admin.avatar'))->image();
                $form->media('video_lb', __('admin.video'))->video();
                $form->media('gallery_lb', __('site.gallery'))->image()->multiple();
            })
            ->tab(__('site.location'), function (Form $form) {
                $form->address('address');
            })
            ->tab(__('site.content'), function (Form $form) {
                $form->textarea('description_lb', __('admin.description'));
                $form->editor('content_lb', __('site.content'));
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
            if ($form->input('amenities')) {
                $form->amenities = array_filter($form->input('amenities'), function ($value){
                    return !is_null($value) && $value !== '';
                });
            }
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
