<?php

namespace App\Admin\Controllers;

use App\Admin\Forms\ToolTranslatable;
use App\Admin\Repositories\Amenity;
use App\Admin\Forms\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\IFrameGrid;
use Dcat\Admin\Controllers\AdminController;
use Dcat\Admin\Models\Administrator as AdministratorModel;
use Dcat\Admin\Show;
use Dcat\Admin\Support\Helper;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;

class AmenityController extends AdminController
{
    protected function title()
    {
        return __('site.amenities');
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new Amenity(), function (Grid $grid) {
            $grid->model()->orderByDesc('updated_at');
            $grid->id('ID')->code()->sortable();
            $grid->title_lb(__('admin.title'))->editable();
            $grid->language_lb(__('site.lang'))->label();
            $grid->type_lb(__('site.type'))->label();
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
                $filter->scope('new', __('site.today'))
                    ->whereDate('created_at', date('Y-m-d'))
                    ->orWhereDate('updated_at', date('Y-m-d'));
                foreach (config('site.locales') as $locale) {
                    $filter->scope('lang_' . $locale, __('site.' . $locale))
                        ->where('language_lb', $locale);
                }
            });
            $grid->showQuickEditButton();
            $grid->enableDialogCreate();
        });
    }

    /**
     * @return IFrameGrid
     */
    protected function iFrameGrid()
    {
        $grid = new IFrameGrid(new Amenity());
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
        return Show::make($id, new Amenity(), function (Show $show) {
            $show->id;
            $show->title_lb(__('admin.title'));
            $show->field('name_lb', __('Name'));
            $show->field('email_lb', __('Email'));
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
        $form = new Form(new Amenity);
        $form->tools([ToolTranslatable::make()]);
        $form->text('title_lb', __('admin.title'));
        $form->select('type_lb', __('admin.type'))->options([
            'direction' => __('site.direction'),
            'amenity' => __('site.amenity'),
            'device' =>  __('site.device'),
            'furniture' =>  __('site.furniture'),
        ]);
        $form->hidden('language_lb')->default(config('site.locale_default'));
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
//            Permission::error();
        }

        return parent::destroy($id);
    }
}
