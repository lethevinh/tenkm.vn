<?php

namespace App\Admin\Forms;
use App\Models\Course;
use App\Models\Section;
use Dcat\Admin\Admin;
use Dcat\Admin\Form;
use Dcat\Admin\Form\Field;
use Dcat\Admin\Form\NestedForm;
use Illuminate\Support\Str;
use function GuzzleHttp\Psr7\str;

class Table extends Field\Table
{
    protected $views = ['table' => 'admin.form.table'];

    /**
     * Setup default template script.
     *
     * @param string $templateScript
     *
     * @return void
     */
    protected function setupScriptForTableView($templateScript)
    {
        $removeClass = NestedForm::REMOVE_FLAG_CLASS;
        $defaultKey = NestedForm::DEFAULT_KEY_NAME;

        $fieldId = str_replace('[', '-', $this->getElementName());
        $fieldId = Str::replaceLast(']', '', $fieldId);
        $fieldId = str_replace(']', '-', $fieldId);
        /**
         * When add a new sub form, replace all element key in new sub form.
         *
         * @example comments[new___key__][title]  => comments[new_{index}][title]
         *
         * {count} is increment number of current sub form count.
         */
        $script = <<<JS
(function () {

    var nestedIndex = 0;
    console.log('#has-many-{$this->column}-{$fieldId}')
    if ($('#has-many-{$this->column}-{$fieldId}').length > 0) {
            $('#has-many-{$this->column}-{$fieldId}').on('click', '.x-add', function () {
                var tpl = $('template.{$this->column}-{$fieldId}-tpl');

                nestedIndex++;

                var template = tpl.html().replace(/{$defaultKey}/g, nestedIndex);
                $('.has-many-{$this->column}-{$fieldId}-forms').append(template);
                {$templateScript}
            });
    }

    $('#has-many-{$this->column}-{$fieldId}').on('click', '.x-remove', function () {
        $(this).closest('.has-many-{$this->column}-{$fieldId}-form').hide();
        $(this).closest('.has-many-{$this->column}-{$fieldId}-form').find('.$removeClass').val(1);
    });
})();
JS;

        Admin::script($script);
    }

    public function render()
    {
        $fieldId = str_replace('[', '-', $this->getElementName());
        $fieldId = Str::replaceLast(']', '', $fieldId);
        $fieldId = str_replace(']', '-', $fieldId);
        $this->addVariables(['fieldId' => $fieldId]);
        return parent::render();
    }

}
