<?php

namespace App\Admin\Forms;

use Dcat\Admin\Form\Field;

class CKEditor extends Field
{
    public static $js = [
        '/plugins/ckeditor/ckeditor.js',
        '/plugins/ckeditor/adapters/jquery.js',
        '/plugins/ckfinder/ckfinder.js',
    ];

    protected $view = 'admin.ckeditor';

    public function render()
    {
        $this->script = <<<JS
$('textarea.{$this->getElementClassString()}').ckeditor({
                  filebrowserBrowseUrl: '/admin/ckfinder/browser',
                  filebrowserImageBrowseUrl: '/admin/ckfinder/browser?type=Images',
                  filebrowserUploadUrl: '/admin/ckfinder/connector?command=QuickUpload&type=Files',
                  filebrowserImageUploadUrl: '/admin/ckfinder/connector?command=QuickUpload&type=Images',
                  uploadUrl: '/admin/ckfinder/connector?command=QuickUpload&type=Files&responseType=json'
        });
JS;
        return parent::render();
    }
}
