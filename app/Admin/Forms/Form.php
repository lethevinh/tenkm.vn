<?php


namespace App\Admin\Forms;
use Closure;
use Illuminate\Http\Request;

/**
 * @method media(string $string, array|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Translation\Translator|string|null $__)
 */
class Form extends \Dcat\Admin\Form
{
    public function __construct($repository = null, ?Closure $callback = null, Request $request = null)
    {
        parent::__construct($repository, $callback, $request);
        $this->__hooks['submitted'][] = function (Form $form){
            $model = $this->repository()->eloquent();
            // Custom Metafield
            if (method_exists($model, 'metas')) {
                foreach ($form->builder()->fields() as $field) {
                    if (strpos($field->column(), 'metas') > -1) {
                        $field->updateInputValues($form->input($field->column()));
                        $form->ignore([$field->column()]);
                    }
                }
            }
            if (method_exists($model, 'tags') && !empty($tags = $form->input('tags')) && $model->id) {
                $model->detachTags($model->tags);
                unset($tags[count($tags) - 1]);
                $model->attachTags($tags);
            }
            $form->ignore('tags');
        };
    }
}
