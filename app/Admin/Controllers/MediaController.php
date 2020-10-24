<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\Media;
use App\Models\Resource;
use App\Models\Section;
use App\Services\MediaManager;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\IFrameGrid;
use Dcat\Admin\Controllers\AdminController;
use Dcat\Admin\Layout\Content;
use Dcat\Admin\Models\Administrator as AdministratorModel;
use Dcat\Admin\Models\Repositories\Administrator;
use Dcat\Admin\Traits\HasUploadedFile;
use Dcat\Admin\Widgets\DialogForm;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class MediaController extends AdminController
{
    use HasUploadedFile;

    protected function title()
    {
        return __('site.media');
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new Media(['resources', 'creator']), function (Grid $grid) {
            $grid->id('ID')->sortable();
            $grid->model()->orderByDesc('updated_at');
            $grid->image_lb->image('', 150, 50);
            $grid->title_lb(__('admin.title'));
            $grid->resources(__('admin.resource'))->count()->label('primary', 2);
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

            $grid->disableBatchDelete();
            $grid->showQuickEditButton();
            $grid->disableFilterButton();
            $grid->enableDialogCreate();
            $grid->actions(function (Grid\Displayers\Actions $actions) {
                if ($actions->getKey() == AdministratorModel::DEFAULT_ID) {
                  //  $actions->disableDelete();
                }
            });
        });
    }

    protected function iFrameGrid()
    {
        $grid = new IFrameGrid(new Media());
        $grid->model()->orderBy('created_at', 'desc');
        $grid->quickSearch(['id', 'title_lb']);
        $grid->rowSelector()->titleColumn('title_lb');

        $grid->id->sortable();
        $grid->title_lb(__('Media Title'));
        $grid->created_at->display(function($value) {
            return Carbon::make($value)->diffForHumans();
        });
        $grid->filter(function (Grid\Filter $filter) {
            $filter->equal('id');
            $filter->like('title_lb');
        });

        return $grid;
    }
    /**
     * Make a form builder.
     *
     * @return Form
     */
    public function form()
    {
        $form = new Form(new Media());
        if ($form->isEditing()) {
            $form->text('id', __('ID'));
        }
        $form->text('title_lb', __('admin.title'))->required();
        $form->image('image_lb', __('admin.avatar'));
        $form->select('type_lb', __('admin.type'))->options([
            'file' => __('admin.file'),
            'video' => __('admin.video')
        ])->default('video');
        $form->file('path_lb', __('admin.choose_file'));
        $form->hidden('status_sl')->value('public');
        return $form;
    }

    public function folders(Content $content) {
        if (request(DialogForm::QUERY_NAME)) {
            return $content->perfectScrollbar()->body($this->iFrameGrid());
        }
    }

    public function popup(Content $content) {
        $content = $content->perfectScrollbar()->full();
        return $this->folder($content);
    }

    public function folder(Content $content) {
        if (request(DialogForm::QUERY_NAME)) {
            $content = $content->perfectScrollbar()->full();
        }
        if (request('_view') === 'popup') {
            $content = $content->perfectScrollbar()->full();
        }
        $default = config('admin.upload.disk'). '/'.config('admin.upload.directory.file');
        $path = request()->input('path', $default);
        $view = request()->input('view', 'list');
        $listPath = explode('/', $path);
        $path = (count($listPath) > 1 && $listPath[1] === 'files' )  ? $path : $default;
        $manager = new MediaManager($path);
        return $content
            ->title($this->title())
            ->description($this->description()['show'] ?? trans('admin.show'))
            ->body(view('admin.grid.media', [
                'list'   => $manager->ls(),
                'nav'    => $manager->navigation(),
                'url'    => $manager->urls(),
                'view'   => $view
            ]));
    }

    public function download(Request $request)
    {
        $file = $request->get('file');

        $manager = new MediaManager($file);

        return $manager->download();
    }

    public function upload(Request $request)
    {
        $files = $request->file('files');
        $dir = $request->get('dir', '/');

        $manager = new MediaManager($dir);

        try {
            if ($manager->upload($files)) {
                admin_toastr(trans('admin.upload_succeeded'));
            }
        } catch (\Exception $e) {
            admin_toastr($e->getMessage(), 'error');
        }

        return back();
    }

    public function metadataUpload() {

        $disk = $this->disk('local');

        // 判断是否是删除文件请求
        if ($this->isDeleteRequest()) {
            // 删除文件并响应
            return $this->deleteFileAndResponse($disk);
        }

        $file = $this->file();

        $column = $this->uploader()->upload_column;

        $dir = config('admin.upload.directory.file');
        $newName = $column.'-meta.'.$file->getClientOriginalName();

        $result = $disk->putFileAs('public/'.$dir, $file, $newName);

        $path = "{$dir}/$newName";

        return $result
            ? $this->responseUploaded($path, $path)
            : $this->responseErrorMessage('文件上传失败');

    }

    public function delete(Request $request)
    {
        $files = $request->get('files');

        $manager = new MediaManager();

        try {
            if ($manager->delete($files)) {
                return response()->json([
                    'status'  => true,
                    'message' => trans('admin.delete_succeeded'),
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status'  => true,
                'message' => $e->getMessage(),
            ]);
        }
    }

    public function move(Request $request)
    {
        $path = $request->get('path');
        $new = $request->get('new');

        $manager = new MediaManager($path);

        try {
            if ($manager->move($new)) {
                return response()->json([
                    'status'  => true,
                    'message' => trans('admin.move_succeeded'),
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status'  => true,
                'message' => $e->getMessage(),
            ]);
        }
    }

    public function newFolder(Request $request)
    {
        $dir = $request->get('dir');
        $name = $request->get('name');

        $manager = new MediaManager($dir);

        try {
            if ($manager->newFolder($name)) {
                return response()->json([
                    'status'  => true,
                    'message' => trans('admin.move_succeeded'),
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status'  => true,
                'message' => $e->getMessage(),
            ]);
        }
    }
}
