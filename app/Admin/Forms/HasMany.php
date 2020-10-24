<?php

namespace App\Admin\Forms;
use App\Models\Course;
use App\Models\Section;
use Dcat\Admin\Admin;
use Dcat\Admin\Form;
use Dcat\Admin\Form\Field;

class HasMany extends Field\HasMany
{
    protected $views = ['default' => 'admin.form.hasmany'];

    public function render()
    {
        return parent::render();
    }
}
