<?php

namespace App\Admin\Grids;

use Dcat\Admin\Admin;

use Dcat\Admin\Grid\Displayers\SwitchDisplay;

class Status extends SwitchDisplay
{
    protected function setupScript()
    {
        Admin::script(
            <<<JS
(function(){
    var swt = $('.grid-switch-{$this->grid->getName()}'), t;
    function init(){
        swt.parent().find('.switchery').remove();
        swt.each(function(k){
            t = $(this);
            new Switchery(t[0], t.data())
        })
    }
    init();
    swt.off('change').change(function(e) {
        var t = $(this), id = t.data('key'), checked = t.is(':checked'), name = t.attr('name'), data = {
            _token: Dcat.token,
            _method: 'PUT'
        };
        data[name] = checked ? 'public' : 'private';
        Dcat.NP.start();

        $.ajax({
            url: "{$this->resource()}/" + id,
            type: "POST",
            data: data,
            success: function (d) {
                Dcat.NP.done();
                if (d.status) {
                    Dcat.success(d.message);
                } else {
                    Dcat.error(d.message);
                }
            }
        });
    });
})();
JS
        );
    }
}
