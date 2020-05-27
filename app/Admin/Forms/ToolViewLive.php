<?php

namespace App\Admin\Forms;

use Dcat\Admin\Form\AbstractTool;
use Dcat\Admin\Actions\Response;
use Dcat\Admin\Traits\HasPermissions;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class ToolViewLive extends AbstractTool
{
    /**
     * @return string
     */
    protected $title = 'Title';

    /**
     * Handle the action request.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function handle(Request $request)
    {
        // dump($this->getKey());

        return $this->response()
            ->success('Processed successfully.')
            ->redirect('/');
    }

    /**
     * @return string|void
     */
    protected function href()
    {
        // return admin_url('auth/users');
    }

    /**
     * @return string|array|void
     */
    public function confirm()
    {
        // return ['Confirm?', 'contents'];
    }

    /**
     * @param Model|Authenticatable|HasPermissions|null $user
     *
     * @return bool
     */
    protected function authorize($user): bool
    {
        return true;
    }

    /**
     * @return array
     */
    protected function parameters()
    {
        return [];
    }

    public function render()
    {
        $model = $this->parent->repository()->eloquent();
        if (empty($model->id)) {
            return '';
        }
        $list = trans('site.view_post');
        return <<<HTML
<div class="btn-group pull-right btn-mini" style="margin-right: 5px">
    <a target="_blank" href="{$model->link}" class="btn btn-sm btn-outline-success">
        <i class="feather icon-eye"></i><span class="d-none d-sm-inline"> {$list}</span>
    </a>
</div>
HTML;
    }
}
