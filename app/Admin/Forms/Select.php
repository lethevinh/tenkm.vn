<?php

namespace App\Admin\Forms;

use Dcat\Admin\Admin;
use Dcat\Admin\Form\Field\Select as BaseSelect;
use Illuminate\Support\Str;

class Select extends BaseSelect
{
    /**
     * Load options for other selects on change.
     *
     * @param string $fields
     * @param string $sourceUrls
     * @param string $idField
     * @param string $textField
     *
     * @return BaseSelect
     */
    public function loads($fields = [], $sourceUrls = [], string $idField = 'id', string $textField = 'text'): BaseSelect
    {
        $fieldsStr = implode('^', array_map(function ($field) {
            if (Str::contains($field, '.')) {
                return $this->normalizeElementClass($field).'_';
            }

            return $this->normalizeElementClass($field);
        }, (array) $fields));
        $urlsStr = implode('^', array_map(function ($url) {
            return admin_url($url);
        }, (array) $sourceUrls));

        $script = <<<JS
(function () {
    console.log('custom select')
    var fields = '$fieldsStr'.split('^');
    var urls = '$urlsStr'.split('^');

    var refreshOptions = function(url, target) {
        $.ajax(url).then(function(data) {
            target.find("option").remove();
            $(target).select2({
                data: $.map(data, function (d) {
                    d.id = d.$idField;
                    d.text = d.$textField;
                    return d;
                })
            }).val(target.attr('data-value').split(',')).trigger('change');
        });
    };

    $(document).off('change', "{$this->getElementClassSelector()}");
    $(document).on('change', "{$this->getElementClassSelector()}", function () {
        var _this = this;
        var promises = [];

        fields.forEach(function(field, index){
            var target = $(_this).closest('.fields-group').find('.' + fields[index]);

            if (_this.value !== '0' && ! _this.value) {
                return;
            }
            promises.push(refreshOptions(urls[index] + "?q="+ _this.value, target));
        });

        $.when(promises).then(function() {});
    });
    $("{$this->getElementClassSelector()}").trigger('change');
})()
JS;

        Admin::script($script);

        return $this;
    }

}
