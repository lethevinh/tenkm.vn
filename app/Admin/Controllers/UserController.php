<?php

namespace App\Admin\Controllers;

use App\Admin\Forms\ToolViewLive;
use App\Admin\Metrics\Examples;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Certificate;
use App\Models\Course;
use App\Models\Package;
use App\Models\Skill;
use App\Admin\Repositories\User;
use Dcat\Admin\Auth\Permission;
use Dcat\Admin\Controllers\Dashboard;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\IFrameGrid;
use Dcat\Admin\Layout\Column;
use Dcat\Admin\Layout\Content;
use Dcat\Admin\Layout\Row;
use Dcat\Admin\Controllers\AdminController;
use Dcat\Admin\Models\Administrator as AdministratorModel;
use Dcat\Admin\Models\Repositories\Administrator;
use Dcat\Admin\Show;
use Dcat\Admin\Support\Helper;
use Dcat\Admin\Widgets\Tree;
use Illuminate\Support\Carbon;

class UserController extends AdminController
{
    public function index(Content $content)
    {
        if (request(IFrameGrid::QUERY_NAME)) {
            return $content->perfectScrollbar()->body($this->iFrameGrid());
        }
        return $content
            ->header(__('admin.user'))
            ->description('Description...')
            ->body(function (Row $row) {
                $row->column(12, function (Column $column) {
                    $column->row(function (Row $row) {
                        $row->column(6, new Examples\NewUsers());
                        $row->column(6, new Examples\NewDevices());
                    });
                });

                $row->column(12, function (Column $column) {
                    $column->row($this->grid());
                });
            });
    }
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new User(), function (Grid $grid) {

            $grid->model()->orderByDesc('updated_at');
            $grid->id('ID')->sortable();
            $grid->avatar(__('admin.avatar'))->image('', 150, 50);
            $grid->username(__('admin.username'));
            $grid->name(__('admin.name'));
            $grid->phone(__('admin.phone'));
            $grid->email(__('admin.email'));
            $grid->type_lb(__('admin.type'));
            $grid->skills(__('admin.skill'))->count()->label();
            $grid->awards(__('admin.award'))->count()->label();
            $grid->created_at(__('admin.created_at'))->display(function ($at) {
                return Carbon::make($at)->diffForHumans();
            });
            $grid->updated_at(__('admin.updated_at'))->sortable()->display(function ($at) {
                return Carbon::make($at)->diffForHumans();
            });

            $grid->quickSearch(['id', 'name', 'username']);

            $grid->disableBatchDelete();
            $grid->showQuickEditButton();
            $grid->disableFilterButton();
            $grid->enableDialogCreate();
            $grid->actions(function (Grid\Displayers\Actions $actions) {
                if ($actions->getKey() == AdministratorModel::DEFAULT_ID) {
//                    $actions->disableDelete();
                }
            });
        });
    }

    /**
     * @return IFrameGrid
     */
    protected function iFrameGrid()
    {
        $grid = new IFrameGrid(new User());

        $grid->quickSearch(['id', 'name', 'username']);

        $grid->id->sortable();
        $grid->username;
        $grid->name;
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
        return Show::make($id, new User(), function (Show $show) {
            $show->id;
            $show->username;
            $show->name;

            $show->avatar(__('admin.avatar'))->image();

            $show->roles->as(function ($roles) {
                if (! $roles) {
                    return;
                }

                return collect($roles)->pluck('name');
            })->label();

            $show->permissions->unescape()->as(function () {
                $roles = (array) $this->roles;

                $permissionModel = config('admin.database.permissions_model');
                $roleModel = config('admin.database.roles_model');
                $permissionModel = new $permissionModel();
                $nodes = $permissionModel->allNodes();

                $tree = Tree::make($nodes);

                $isAdministrator = false;
                foreach (array_column($roles, 'slug') as $slug) {
                    if ($roleModel::isAdministrator($slug)) {
                        $tree->checkAll();
                        $isAdministrator = true;
                    }
                }

                if (! $isAdministrator) {
                    $keyName = $permissionModel->getKeyName();
                    $tree->check(
                        $roleModel::getPermissionId(array_column($roles, $keyName))->flatten()
                    );
                }

                return $tree->render();
            });

            $show->created_at;
            $show->updated_at;
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    public function form()
    {
        return \App\Admin\Forms\Form::make(new User([  'metas', 'categories']), function (Form $form) {
            $userID = request()->route()->parameter('user');
            $form->disableViewButton();
            $form->tab(__('admin.basic'), function (Form $form) use ($userID) {
                $userTable = 'users';
                $id = $form->getKey();
                $connection = config('admin.database.connection');
                $form->text('username', trans('admin.username'))
                    ->required()
                    ->creationRules(['required', "unique:{$connection}.{$userTable}"])
                    ->updateRules(['required', "unique:{$connection}.{$userTable},username,$id"]);
                $form->text('name', __('admin.name'))->required();
                $form->email('email', __('admin.email'))
                    ->required()
                    ->creationRules(['required', "unique:{$connection}.{$userTable}"])
                    ->updateRules(['required', "unique:{$connection}.{$userTable},email,$id"]);
                $form->mobile('phone', __('admin.phone'))
                    ->saving(function ($value) {
                        return str_replace('_', '', $value);
                    })->required()
                    ->required()
                    ->creationRules(['required', "unique:{$connection}.{$userTable}"])
                    ->updateRules(['required', "unique:{$connection}.{$userTable},phone,$id"]);

                $form->text('address', __('site.address'));
                $form->select('type_lb', __('admin.type'))->options([
                    'member' => 'Member',
                    'guest' => 'Guest',
                ]);
                $form->multipleSelect('categories', __('site.category'))
                    ->options(function () {
                        return Category::all()->pluck('title_lb', 'id');
                    })
                    ->customFormat(function ($v) {
                        return array_column($v, 'id');
                    });
            })
                ->tab(__('admin.profile'), function (Form $form) {
                    $form->textarea('description', __('Description'));
                    $form->media('avatar', __('Avatar'))->image();
                })
                ->tab(__('admin.social'), function (Form $form) {
                    $form->meta('facebook', __('facebook'))->type('text');
                    $form->meta('twitter', __('twitter'))->type('text');
                    $form->meta('instagram', __('instagram'))->type('text');
                    $form->meta('youtube', __('youtube'))->type('text');
                    $form->meta('website', __('website'))->type('text');
                    $form->meta('company', __('company'))->type('text');
                    $form->meta('skype', __('skype'))->type('text');
                })
                ->tab(__('admin.security'), function (Form $form) {
                    //$form->multipleSelect('tokens')->options(PersonalAccessToken::all()->pluck('title_lb', 'id'))->readOnly()->disable();
                });
        })->submitted(function (Form $form) {
            foreach ($form->builder()->fields() as $field) {
                if (strpos($field->column(), 'metas') > -1) {
                    $field->updateInputValues($form->input($field->column()));
                    $form->ignore([$field->column()]);
                }
            }
        });
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
