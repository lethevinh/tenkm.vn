<?php

namespace App\Admin\Forms;

use Dcat\Admin\Form\AbstractTool;
use Dcat\Admin\Actions\Response;
use Dcat\Admin\Traits\HasPermissions;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class ToolTranslatable extends AbstractTool
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
        $list = trans('site.translation');
        $locales = config('site.locales', ['vi']);
        if ($model->language_lb !== config('site.locale_default')) {
            $translations = $model->translator->translations->add($model->translator)->where('id', '<>', $model->id);
        }else{
            $translations = $model->translations;
        }
        return view('admin.form.translation', compact('list', 'locales', 'model', 'translations'));
    }
}
