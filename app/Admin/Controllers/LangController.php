<?php

namespace App\Admin\Controllers;

use App\Admin\Forms\ToolTranslatable;
use App\Admin\Repositories\Lang;
use App\Admin\Forms\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\IFrameGrid;
use Dcat\Admin\Controllers\AdminController;
use Dcat\Admin\Show;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;

class LangController extends AdminController
{
    protected function title()
    {
        return __('site.language');
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new Lang(), function (Grid $grid) {
            $grid->model()->orderByDesc('updated_at');
            $grid->id('ID')->code()->sortable();
            $grid->key_lb(__('admin.key'));
            $grid->value_lb(__('site.value'))->editable();
            $grid->language_lb(__('site.lang'))->label();
            $grid->quickSearch(['id', 'key_lb', 'value_lb']);
            $grid->filter(function (Grid\Filter $filter) {
                $filter->panel();
                $filter->like('key_lb', __('admin.title'))->width(3);
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
        $grid = new IFrameGrid(new Lang());
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
        return Show::make($id, new Lang(), function (Show $show) {
            $show->id;
            $show->key_lb(__('site.key'));
            $show->field('value_lb', __('site.value'));
            $show->field('language_lb', __('site.language'));
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    public function form()
    {
        $form = new Form(new Lang);
        $form->text('key_lb', __('site.key'));
        $form->text('value_lb', __('site.value'));
        $form->select('language_lb', __('site.language'))
            ->options(['vi' => "VN", 'en' => 'EN'])
            ->default(config('site.locale_default'));
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
        return parent::destroy($id);
    }
}
