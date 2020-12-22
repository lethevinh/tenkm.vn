<?php

use Dcat\Admin\Admin;
use Dcat\Admin\Form;
use Dcat\Admin\Grid\Column;
/**
 * Dcat-admin - admin builder based on Laravel.
 * @author jqh <https://github.com/jqhph>
 *
 * Bootstraper for Admin.
 *
 * Here you can remove builtin form field:
 *
 * extend custom field:
 * Dcat\Admin\Form::extend('php', PHPEditor::class);
 * Dcat\Admin\Grid\Column::extend('php', PHPEditor::class);
 * Dcat\Admin\Grid\Filter::extend('php', PHPEditor::class);
 *
 * Or require js and css assets:
 * Admin::css('/packages/prettydocs/css/styles.css');
 * Admin::js('/packages/prettydocs/js/main.js');
 *
 */
use App\Admin\Forms\CKEditor;
use App\Admin\Forms\Media;
use App\Admin\Forms\HasMany;
use App\Admin\Forms\Table;
use App\Admin\Grids\Status;
use App\Admin\Forms\Lecture;
use App\Admin\Forms\Metadata;
use App\Admin\Forms\Address;
use App\Admin\Forms\Select;

//icheck
Admin::css('plugins/icheck/skins/minimal/_all.css');
Admin::js('plugins/icheck/icheck.min.js');
Admin::js('plugins/hotkeys.min.js');

Admin::css('/css/bundle-admin.css');
Admin::js('/js/bundle-admin.js');
Admin::js('/js/vi-admin.js');
Form\Field\Map::collectAssets();
Admin::script("$('body').addClass('skin-vi-admin');window.admin.init()");
Form::extend('editor', CKEditor::class);
Form::extend('lecture', Lecture::class);
Form::extend('media', Media::class);
Form::extend('xHasMany', HasMany::class);
Form::extend('xTable', Table::class);
Form::extend('meta', Metadata::class);
Form::extend('address', Address::class);
Column::extend('status', Status::class);
Form::extend('xSelect', Select::class);

Admin::navbar(function (\Dcat\Admin\Layout\Navbar $navbar) {

    $navbar->left(view('admin.nav.left'));

    $navbar->right(view('admin.nav.right'));

});
