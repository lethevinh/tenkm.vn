<?php

namespace App\Admin\Controllers;

use App\Admin\Forms\Form;
use App\Admin\Repositories\Address;
use App\Models\Location;
use Dcat\Admin\Grid;
use Dcat\Admin\IFrameGrid;
use Dcat\Admin\Controllers\AdminController;
use Dcat\Admin\Models\Administrator;
use Dcat\Admin\Models\Administrator as AdministratorModel;
use Dcat\Admin\Show;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;

class AddressController extends AdminController
{
    protected function title()
    {
        return __('site.address');
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new Address([]), function (Grid $grid) {
            $grid->model()->orderBy('created_at', 'desc')->whereNull('street_id');
            $grid->id('ID')->code()->sortable();
            $grid->address_lb(__('admin.title'));
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
                $admins = AdministratorModel::all()->pluck('name', 'id');
                $filter->where('creator', function ($query) {
                    $value = $this->input;
                    $query->whereIn('created_by', $value);
                },__('admin.owner'))->width(3)->multipleSelect($admins);
                $filter->scope('new', __('site.today'))
                    ->whereDate('created_at', date('Y-m-d'))
                    ->orWhereDate('updated_at', date('Y-m-d'));
            });
            //$grid->disableBatchDelete();
            $grid->showQuickEditButton();
            //$grid->enableDialogCreate();
        });
    }

    /**
     * @return IFrameGrid
     */
    protected function iFrameGrid()
    {
        $grid = new IFrameGrid(new Partner());
        $grid->quickSearch(['id', 'title_lb']);
        $grid->id->sortable();
        $grid->address_lb;
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
        return Show::make($id, new Address(), function (Show $show) {
            $show->id;
            $show->address_lb(__('admin.title'));
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
        $form = new Form(new Address());
        $form->text('address_lb', __('admin.title'))->required();
        $form->select('provincial_id')
            ->options(Location::ofType('provincial')->get()->pluck('title_lb', 'id'))
            ->load('district_id', 'api/locations');
        $form->select('district_id')
            ->loads(['ward_id' , 'address.street_id'], ['api/locations', 'api/locations/street']);
        $form->select('ward_id')->saving(function ($value) {
            if (!$value) return NULL;
            return $value;
        });
        $form->hidden('status_lb')->value('official')->default('official');
        $form->disableViewCheck();
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
