<?php

namespace App\Admin\Forms;
use App\Models\Course;
use App\Models\Section;
use Dcat\Admin\Admin;
use Dcat\Admin\Form;
use Dcat\Admin\Form\Field;

class Lecture extends Field
{
    protected $view = 'admin.lecture';

    protected static  $js = ['vendors/dcat-admin/dcat/plugins/nestable/jquery.nestable.min.js'];
    protected static $css = ['vendors/dcat-admin/dcat/plugins/nestable/nestable.css'];
    public function render()
    {
        $lectures = [];

        if (!empty($this->value()) && $course = Course::find($this->value())) {
            $lectures = $course->lectures;
            $course->lectures->each(function ($lecture) {
                Form::dialog(__('admin.edit').' '.__('admin.lecture'). ' '. $lecture->title_lb)
                    ->click('.btn-edit-lecture-'.$lecture->id)
                    ->success("window.admin.dialogAfterSave();");
            });
        }
        Form::dialog(__('site.add').' '.__('admin.lecture'))
            ->click('.create-lecture')
            ->saved('console.log("ok")')
            ->success("window.admin.dialogAfterSave();");
        $this->addVariables(['lectures' => $lectures]);
        $this->script = <<<JS
(function () {
    let tree = $('#lecture_{$this->value}');
    tree.nestable({});
})();
JS;
        return parent::render();
    }


}
