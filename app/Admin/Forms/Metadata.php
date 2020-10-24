<?php

namespace App\Admin\Forms;

use Dcat\Admin\Form\Field;
use App\Models\Metadata as Model;
use Illuminate\Support\Str;

class Metadata extends Field
{
    public static $js = [
        '@moment',
        '@bootstrap-datetimepicker',
        '@fontawesome-iconpicker',
        '@jquery.inputmask',
        '@select2',
        '@webuploader',
        '/plugins/ckfinder/ckfinder.js'
    ];

    public static $css = [
        '@bootstrap-datetimepicker',
        '@fontawesome-iconpicker',
        '@jquery.inputmask',
        '@select2',
        '@webuploader'
    ];

    protected $view = 'admin.form.metadata';

    protected $type = 'text';

    protected $keyMeta = '';

    protected $field;
    /**
     * Field constructor.
     *
     * @param string|array $column
     * @param array        $arguments
     */
    public function __construct($column, $arguments = [])
    {
        $this->keyMeta = $column;

        parent::__construct('metas.'.$column, $arguments);
    }

    /**
     * @param $type
     * @return mixed
     */
    public function type($type)
    {
        $this->type = $type;
        return $this;
    }

    public function updateInputValues($value)
    {
        $model = $this->form->repository()->eloquent();
        $value = $this->makeField()->prepare($value);
        $value = is_string($value)? $value : json_encode($value, true);
        if ($model->id && is_string($value)) {
            $model->updateOrCreateMeta($this->keyMeta, $value);
        }
        return $value;
    }

    public function getModelMeta() {
      return Model::where([
            'key_lb' => $this->keyMeta,
            'metadatable_id' => $this->form->getKey()
        ])->first();
    }

    protected function getFieldType() {
        return 'Dcat\Admin\Form\Field\\'.ucfirst($this->type);
    }

    /**
     * @return Field\MultipleSelect|mixed
     */
    protected function makeField() {
        $meta = $this->getModelMeta();
        $fieldType = $this->getFieldType();
        if (!class_exists($fieldType)) {
            $fieldType = Field\Text::class;
        }
        $field = new $fieldType($this->column, [$this->label]);
        // default value
        if ($this->default && empty($meta)) {
            if (in_array($this->type, ['file' , 'image'])) {
                $field->default([$this->default]);
            }else {
                $field->default($this->default);
            }
        }
        if (in_array($this->type,['file' , 'image'])) {
            $field->url('media/metadata-upload')->disableAutoSave();
        }
        $params = explode('_', $this->type);
        // MultipleSelect
        if (count($params) >= 2 && $params[0] == 'select') {
            $nameSource = $params[1];
            $singular = Str::singular($nameSource) === $nameSource;
            $nameSource = $singular ? $nameSource : Str::singular($nameSource);
            $classSource = 'App\\Models\\'.ucfirst($nameSource);
            if (class_exists($classSource)) {
                $field = $singular ? new Field\Select($this->column, [$this->label]) : new Field\MultipleSelect($this->column, [$this->label]);
                $field->options(function () use ($classSource, $nameSource, $params) {
                    $typesUser = ['user'];
                    $name = (in_array($nameSource, $typesUser)) ? 'name': 'title_lb';
                    if (count($params) === 3 && $params[1] == 'category') {
                        return $classSource::ofType($params[2])->get()->pluck($name, 'id');
                    }
                    return $classSource::all()->pluck($name, 'id');
                })->customFormat(function ($v) {
                    return array_column($v, 'id');
                });
            }
        }
        // Media Field
        if ($this->type === 'media') {
            $this->type = 'media_image';
        }
        if (count($params) >= 1 && $params[0] == 'media') {
            $nameSource = $params[1];
            $singular = Str::singular($nameSource) === $nameSource;
            $field = new Media($this->column, [$this->label]);
            if (method_exists($field, $nameSource)) {
                $field->$nameSource();
            }else{
                $field->image();
            }
            if (!$singular) {
                $field->multiple();
            }
        }
        // Mobile
        if ($this->type === 'mobile') {
            $field->saving(function ($value) {
                return str_replace('_', '', $value);
            });
        }
        $field->addVariables($this->variables());
        // current value
        if ($meta && !empty($meta->value_lb) && $meta->value_lb !== 'null') {
            if (strpos($this->type, 'select_') > -1 ) {
                $singular = Str::singular($params[1]) === $params[1];
                $value = json_decode($meta->value_lb, true);
                $value = $singular && isset($value[0])? $value[0]: $value;
                $field->value($value);
            }elseif (in_array($this->type,['file' , 'image'])) {
                $value = is_array($meta->value_lb) ? $meta->value_lb : [$meta->value_lb];
                $field->value($value);
            }elseif (strpos($this->type, 'media_') > -1 ) {
                $singular = Str::singular($params[1]) === $params[1];
                $value = explode(',', $meta->value_lb);
                $value = $singular ? [$value[0]] : $value;
                $field->value($value);
            }else{
                $field->value($meta->value_lb);
            }
        }
        return $field;
    }

    public function render()
    {
        $this->addVariables([
            'metaKey' => $this->keyMeta,
            'field' => $this->makeField()
        ]);
        return parent::render();
    }
}
