<?php

namespace App\Admin\Forms;

use Dcat\Admin\Form\Field;
use Dcat\Admin\Form\NestedForm;
use Dcat\Admin\Support\JavaScript;

class Media extends Field\File
{

    protected $view = 'admin.media';

    protected $multiple = false;

    protected $resourceType = 'Files';

    protected $icons = [
        'video' => '/plugins/ckfinder/skins/neko/file-icons/128/video.png',
        'pdf' => '/plugins/ckfinder/skins/neko/file-icons/128/pdf.png',
        'msword' => '/plugins/ckfinder/skins/neko/file-icons/128/msword.png',
        'unknow' => '/plugins/ckfinder/skins/neko/file-icons/128/unknow.png',
    ];

    protected static $css = [
        '@webuploader',
    ];

    protected static $js = [
        '@webuploader',
        '/plugins/ckfinder/ckfinder.js'
    ];

    public function multiple()
    {
        $this->multiple = true;
        return $this;
    }

    public function image()
    {
        $this->resourceType = "Images";
        return $this;
    }

    public function file()
    {
        $this->resourceType = "Files";
        return $this;
    }

    public function video()
    {
        $this->resourceType = "Videos";
        return $this;
    }

    public function document()
    {
        $this->resourceType = "Documents";
        return $this;
    }

    protected function initialPreviewConfig()
    {
        $previews = [];
        $values = $this->value();
        $values = is_array($values) ? $values : [$values];
        if (count($values) === 0) return $previews;
        if ($this->multiple) {
            foreach ($values as $value) {
                $url = $this->objectUrl($value);
                $url = strpos($value, 'mp4') > -1 ? $this->icons['video'] : $url;
                $url = strpos($value, 'pdf') > -1 ? $this->icons['pdf'] : $url;
                $url = strpos($value, 'doc') > -1 ? $this->icons['msword'] : $url;
                $url = strpos($value, 'docx') > -1 ? $this->icons['msword'] : $url;
                $previews[] = [
                    'id'   => $value,
                    'path' => basename($value),
                    'url'  => $url,
                ];
            }
        }else{
            $value = $values[0];
            $url = $this->objectUrl($value);
            $url = strpos($value, 'mp4') > -1 ? $this->icons['video'] : $url;
            $url = strpos($value, 'pdf') > -1 ? $this->icons['pdf'] : $url;
            $url = strpos($value, 'doc') > -1 ? $this->icons['msword'] : $url;
            $url = strpos($value, 'docx') > -1 ? $this->icons['msword'] : $url;
            $previews = [[
                'id'   => $value,
                'path' => basename($value),
                'url'  => $url,
            ]];
        }

        return $previews;
    }

    protected function prepareInputValue($file)
    {
        return $file;
    }

    protected function setUpScript()
    {
        $newButton = trans('admin.uploader.add_new_media');
        $options = JavaScript::format($this->options);
        $hasManyKey = NestedForm::DEFAULT_KEY_NAME;

        $this->script = <<<JS
(function () {
    let uploader,
    newPage,
    cID = '#{$this->containerId}',
    ID = '#{$this->id}',
    hasManyKey = '{$hasManyKey}',
    options = {$options};
    if ($(cID + ' .web-uploader').length === 0) return
    if (typeof nestedIndex !== "undefined") {
        cID = cID.replace(hasManyKey, nestedIndex);
        ID = ID.replace(hasManyKey, nestedIndex);
    }

    build();

    function build() {
        const opts = $.extend({
            selector: cID,
            addFileButton: cID+' .add-file-button',
            inputSelector: ID,
        }, options);

        opts.upload = $.extend({
            pick: {
                id: cID+' .file-picker',
                name: '_file_',
                label: '<i class="feather icon-folder"></i>&nbsp; {$newButton}'
            },
            dnd: cID+' .dnd-area',
            paste: cID+' .web-uploader'
        }, opts);

        uploader = Dcat.Uploader(opts);

        uploader.build();
        uploader.preview();

        uploader.reload = function() {
            $(cID + ' .queueList .filelist').html('');
            this.preview();
            let output = document.getElementById('{$this->id}');
            output.value = this.options.preview.map(item => item.url).join(',');
        }
        uploader.removeFile = function(id) {
            this.options.preview = this.options.preview.filter(item => item.id !== id);
            this.reload();
        };
        uploader.addButtonMedia = function() {
            let _this = uploader;
            if (!window.CKFinder) return;
            // window.CKFinder._connectors.php = '/admin/ckfinder/connector';
            console.log(window.CKFinder)
            window.CKFinder.popup( {
                connectorPath: '/admin/ckfinder/connector',
                chooseFiles: true,
                selectMultiple: uploader.options.multiple,
                resourceType: '{$this->resourceType}',
                editImageAdjustments: ['brightness', 'clip', 'contrast', 'exposure', 'gamma', 'hue', 'noise', 'saturation', 'sepia','sharpen', 'stackBlur', 'vibrance'],
                editImagePresets: ['clarity', 'concentrate', 'crossProcess', 'glowingSun', 'grungy', 'hazyDays', 'hemingway', 'herMajesty','jarques', 'lomo', 'love', 'nostalgia', 'oldBoot', 'orangePeel', 'pinhole', 'sinCity', 'sunrise', 'vintage'],
                listViewIconSize : 16,
                defaultSortByOrder: 'desc',
                defaultViewType: 'thumbnails',
                onInit: function( finder ) {
                    finder.on( 'files:choose', function( evt ) {
                        if (evt.data.files.length === 0) return;
                        let preview = _this.options.preview;
                        if (!_this.options.multiple) {
                            const file = evt.data.files.first();
                            let fileTmp = {
                                id : file.getUrl(),
                                path : file.attributes.name,
                                url : file.getUrl(),
                            };
                             preview = [fileTmp];
                        } else {
                            for (let i in evt.data.files.models) {
                                let file = evt.data.files.models[i];
                                let fileTmp = {
                                    id : file.getUrl(),
                                    path : file.attributes.name,
                                    url : file.getUrl(),
                                };
                               if ( _this.options.preview.filter(i => i.id === file.getUrl()).length === 0) {
                                    preview.push(fileTmp);
                               }
                            }
                        }
                        _this.options.preview = preview;
                        _this.reload();
                    } );
                    finder.on( 'file:choose:resizedImage', function( evt ) {
                        const output = document.getElementById( elementId );
                        output.value = evt.data.resizedUrl;
                    } );
                }
            } );
        }
        function resize() {
            setTimeout(function () {
                if (! uploader) return;

                uploader.refreshButton();
                resize();

                if (! newPage) {
                    newPage = 1;
                    $(document).one('pjax:complete', function () {
                        uploader = null;
                    });
                }
            }, 250);
        }
        resize();
        let btnRemove = $('.file-panel [data-file-act="deleteurl"]');
        btnRemove.unbind('click');
        $(document).on('click', '.file-panel [data-file-act="deleteurl"]', function() {
                uploader.removeFile($(this).data('id'));
        });
        $('[name="file-{$this->getElementName()}"]').change(function () {
            uploader.uploader.addFiles(this.files);
        });
        // Simulate user action of selecting a file to be returned to CKEditor.
        $('#media-{$this->id}').click((event) => {
            uploader.addButtonMedia();
            event.stopPropagation();
            event.preventDefault();
            return;
        });
    }
})();
JS;
    }

    protected function forceOptions()
    {
        $this->options['fileNumLimit'] = $this->multiple??1;
        $this->options['isImage'] = true;
        $this->options['disableRemove'] = true;
        $this->options['multiple'] = $this->multiple;
    }

    public function render()
    {
        return parent::render();
    }
}

