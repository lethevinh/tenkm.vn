<style>
    .files-container.active {
        display: block;
    }

    .files-container {
        display: none;
    }

    .media-admin .box-footer {
        display: block;
    }

    .breadcrumb > li + li:before {
        padding: 0 5px;
        color: #ccc;
        content: "/\00a0";
    }
    .file-name,
    .folder-name{
        cursor: pointer;
    }

    .files.list.files-container {
        list-style: none;
        margin: 0;
        padding: 0;
    }

    .files.list.files-container > li {
        float: left;
        width: 150px;
        border: 1px solid #eee;
        margin-bottom: 10px;
        margin-right: 10px;
        position: relative;
    }

    .files.list.files-container > li > .file-select {
        position: absolute;
        top: -4px;
        left: -1px;
    }

    .list.files-container .file-icon {
        text-align: center;
        font-size: 65px;
        color: #666;
        display: block;
        height: 100px;
    }

    .list.files-container .file-info {
        text-align: center;
        padding: 10px;
        background: #f4f4f4;
    }

    .list.files-container .folder-name,
    .list.files-container .file-name {
        font-weight: bold;
        color: #666;
        display: block;
        overflow: hidden !important;
        white-space: nowrap !important;
        text-overflow: ellipsis !important;
    }

    .list.files-container .file-size {
        color: #999;
        font-size: 12px;
        display: block;
    }

    .list.files-container .files {
        list-style: none;
        margin: 0;
        padding: 0;
    }

    .list.files-container .file-icon.has-img {
        padding: 0;
    }

    .list.files-container .file-icon.has-img > img {
        max-width: 100%;
        height: auto;
        max-height: 92px;
    }

    .files > li {
        float: left;
        width: 150px;
        border: 1px solid #eee;
        margin-bottom: 10px;
        margin-right: 10px;
        position: relative;
    }

    .table.files-container .file-icon {
        text-align: left;
        font-size: 25px;
        color: #666;
        display: block;
        float: left;
    }

    .table.files-container .action-row {
        text-align: center;
    }

    .table.files-container .folder-name ,
    .table.files-container .file-name {
        font-weight: bold;
        color: #666;
        display: block;
        overflow: hidden !important;
        white-space: nowrap !important;
        text-overflow: ellipsis !important;
        float: left;
        margin: 7px 0px 0px 10px;
    }

    .table.files-container .file-icon.has-img > img {
        max-width: 100%;
        height: auto;
        max-height: 30px;
    }
    .no-margin{
        margin: 0 !important;
    }
</style>

<script data-exec-on-popstate>
    $(function () {
        function currentUrl() {
            return  '{{request()->p}}';
        }
        $('.file-delete').click(function () {
            let path = $(this).data('path');
            Dcat.confirm("{{ trans('admin.delete_confirm') }}", null, function () {
                $.ajax({
                    method: 'delete',
                    url: '{{ $url['delete'] }}',
                    data: {
                        'files[]': [path],
                        _token: Dcat.token
                    },
                    success: function (data) {
                        if (typeof data === 'object') {
                            if (data.status) {
                                Dcat.swal.success(data.message);
                            } else {
                                Dcat.swal.error(data.message);
                            }
                        }
                        Dcat.reload();
                    }
                });
            }, null, {
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "{{ trans('admin.confirm') }}",
                showLoaderOnConfirm: true,
                closeOnConfirm: false,
                cancelButtonText: "{{ trans('admin.cancel') }}",
            });
        });
        $('#moveModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var name = button.data('name');
            var modal = $(this);
            modal.find('[name=path]').val(name)
            modal.find('[name=new]').val(name)
        });
        $('#urlModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var url = button.data('url');
            $(this).find('input').val(url)
        });
        $('#file-move').on('submit', function (event) {
            event.preventDefault();
            var form = $(this);
            var path = form.find('[name=path]').val();
            var name = form.find('[name=new]').val();
            $.ajax({
                method: 'put',
                url: '{{ $url['move'] }}',
                data: {
                    path: path,
                    'new': name,
                    _token: Dcat.token,
                },
                success: function (data) {
                    $.pjax.reload('#pjax-container');
                    if (typeof data === 'object') {
                        if (data.status) {
                            toastr.success(data.message);
                        } else {
                            toastr.error(data.message);
                        }
                    }
                }
            });
            closeModal();
        });
        $('.file-upload').on('change', function () {
            $('.file-upload-form').submit();
        });
        $('#new-folder').on('submit', function (event) {
            event.preventDefault();
            var formData = new FormData(this);
            $.ajax({
                method: 'POST',
                url: '{{ $url['new-folder'] }}',
                data: formData,
                async: false,
                success: function (data) {
                    $.pjax.reload('#pjax-container');
                    if (typeof data === 'object') {
                        if (data.status) {
                            toastr.success(data.message);
                        } else {
                            toastr.error(data.message);
                        }
                    }
                },
                cache: false,
                contentType: false,
                processData: false
            });
            closeModal();
        });
        function closeModal() {
            $("#moveModal").modal('toggle');
            $('body').removeClass('modal-open');
            $('.modal-backdrop').remove();
        }
        $('.media-reload').click(function () {
            //$.pjax.reload('#pjax-container');
            Dcat.realod();
        });
        $('.btn-show').click(function () {
            let view = $(this).data('view');
            Dcat.reload('{{request()->url()}}?path={{request()->query('path')}}&view=' + view);
            $('.btn-show').removeClass('active');
            $(this).addClass('active');
        });
        $('.goto-url button').click(function () {
            var path = $('.goto-url input').val();
            $.pjax({container: '#pjax-container', url: '{{ $url['index'] }}?path=' + path});
        });
        $('.file-select>input').iCheck({checkboxClass: 'icheckbox_minimal-blue'});
        $('.file-select-all input').iCheck({checkboxClass:'icheckbox_minimal-blue'}).on('ifChanged', function () {
            if (this.checked) {
                $('.file-select input').iCheck('check');
            } else {
                $('.file-select input').iCheck('uncheck');
            }
        });
        $('.file-delete-multiple').click(function () {
            var files = $(".file-select input:checked").map(function () {
                return $(this).val();
            }).toArray();
            if (!files.length) {
                return;
            }
            Dcat.confirm("{{ trans('admin.delete_confirm') }}", null, function () {
                $.ajax({
                    method: 'delete',
                    url: '{{ $url['delete'] }}',
                    data: {
                        'files[]': files,
                        _token: Dcat.token
                    },
                    success: function (data) {
                        $.pjax.reload('#pjax-container');
                        if (typeof data === 'object') {
                            if (data.status) {
                                Dcat.swal.success(data.message);
                            } else {
                                Dcat.swal.error(data.message);
                            }
                        }
                    }
                });
            }, null, {
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "{{ trans('admin.confirm') }}",
                showLoaderOnConfirm: true,
                closeOnConfirm: false,
                cancelButtonText: "{{ trans('admin.cancel') }}",
            });
        });
        $('.files-select-all').on('ifChanged', function(event) {
            if (this.checked) {
                $('.grid-row-checkbox').iCheck('check');
            } else {
                $('.grid-row-checkbox').iCheck('uncheck');
            }
        });
        $('table>tbody>tr').mouseover(function () {
            $(this).find('.btn-group').removeClass('hide');
        }).mouseout(function () {
            $(this).find('.btn-group').addClass('hide');
        });
        let folderName = $('.folder-name');
        folderName.click(function (event) {
            event.preventDefault();
            let $this = $(this);
            Dcat.reload($this.data('href'));
        })
        $('.file-name').click(function (event) {
            event.preventDefault();
        });
        folderName.dblclick(function () {
            event.preventDefault();
        })
    });
</script>

<div class="row media-admin">
    <!-- /.col -->
    <div class="col-md-12">
        <div class="box box-primary">

            <div class="box-body no-padding">

                <div class="mailbox-controls with-border">
                    <div class="btn-group">
                        <a href="" type="button" class="btn btn-default btn media-reload" title="Refresh">
                            <i class="fa fa-refresh"></i>
                        </a>
                        <a type="button" class="btn btn-default btn file-delete-multiple" title="Delete">
                            <i class="fa fa-trash-o"></i>
                        </a>
                    </div>
                    <!-- /.btn-group -->
                    <label class="btn btn-default btn"{{-- data-toggle="modal" data-target="#uploadModal"--}}>
                        <i class="fa fa-upload"></i>&nbsp;&nbsp;{{ trans('admin.upload') }}
                        <form action="{{ $url['upload'] }}" method="post" class="file-upload-form"
                              enctype="multipart/form-data" pjax-container>
                            <input type="file" name="files[]" class="hidden file-upload" multiple>
                            <input type="hidden" name="dir" value="{{ $url['path'] }}"/>
                            {{ csrf_field() }}
                        </form>
                    </label>

                    <!-- /.btn-group -->
                    <a class="btn btn-default btn" data-toggle="modal" data-target="#newFolderModal">
                        <i class="fa fa-folder"></i>&nbsp;&nbsp;{{ trans('admin.new_folder') }}
                    </a>

                    <div class="btn-group">
                        <a class="btn btn-default btn-show {{ $view == 'list' ? 'active' : '' }}" data-view="list"><i
                                class="fa fa-list"></i></a>
                        <a class="btn btn-default btn-show {{ $view == 'table' ? 'active' : '' }}" data-view="table"><i
                                class="fa fa-th"></i></a>
                    </div>

                    {{--<form action="{{ $url['index'] }}" method="get" pjax-container>--}}
                    <div class="input-group input-group-sm pull-right goto-url" style="width: 250px;">
                        {{-- <input type="text" name="path" class="form-control pull-right" value="{{ '/'.trim($url['path'], '/') }}">
                         <div class="input-group-btn">
                             <button type="submit" class="btn btn-default"><i class="fa fa-arrow-right"></i></button>
                         </div>--}}
                    </div>
                    {{--</form>--}}

                </div>

                <!-- /.mailbox-read-message -->
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
                <ol class="breadcrumb" style="margin-bottom: 10px;">

                    <li><a href="{{ route('media-index') }}"><i class="fa fa-th-large"></i> </a></li>
                    @foreach($nav as $item)
                        @if($item['name'] != 'public' and $item['name'] != 'files')
                            <li><a href="{{ $item['url'] }}"> {{ $item['name'] }}</a></li>
                        @endif
                    @endforeach
                </ol>
                @if (!empty($list))
                    <ul class="files-container files clearfix list {{ $view == 'table' ? 'active' : '' }}">
                        @foreach($list as $item)
                            <li>
                                <label class="file-select">
                                    <input type="checkbox" value="{{ $item['name'] }}"/>
                                </label>
                                {!! $item['preview'] !!}
                                <div class="file-info ">
                                    <a data-href="{{ $item['link'] }}"
                                       class="@if(!$item['isDir'])file-name @else folder-name @endif" title="{{ $item['name'] }}">
                                        {{ $item['icon'] }} {{ basename($item['name']) }}
                                    </a>
                                    <span class="file-size">
                                        {{ $item['size'] }}&nbsp;
                                        <div class="btn-group btn-group-xs pull-right">
                                    <button type="button" class="btn btn-default btn-xs dropdown-toggle"
                                            data-toggle="dropdown">
                                        <span class="caret"></span>
                                        <span class="sr-only">Toggle Dropdown</span>
                                    </button>
                                    <ul class="dropdown-menu" role="menu">
                                        <li><a href="#" class="file-rename" data-toggle="modal" data-target="#moveModal"
                                               data-name="{{ $item['name'] }}">Rename & Move</a></li>
                                        <li><a href="#" class="file-delete"
                                               data-path="{{ $item['name'] }}">Delete</a></li>
                                        @unless($item['isDir'])
                                            <li><a target="_blank" href="{{ $item['download'] }}">Download</a></li>
                                        @endunless
                                        <li class="divider"></li>
                                        <li><a href="#" data-toggle="modal" data-target="#urlModal"
                                               data-url="{{ $item['url'] }}">Url</a></li>
                                    </ul>
                                </div>
                                    </span>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                    <table class="files-container table table-hover table {{ $view == 'list' ? 'active' : '' }}">
                        <tbody>
                        <tr>
                            <th width="40px;">
                                <label class="file-select-all">
                                    <input type="checkbox" value=""/>
                                </label>
                            </th>
                            <th>{{ trans('admin.name') }}</th>
                            <th></th>
                            <th width="200px;">{{ trans('admin.time') }}</th>
                            <th width="100px;">{{ trans('admin.size') }}</th>
                        </tr>
                        @foreach($list as $item)
                            <tr>
                                <td style="padding-top: 15px;">
                                    <label class="file-select">
                                        <input type="checkbox" value="{{ $item['name'] }}"/>
                                    </label>
                                </td>
                                <td>
                                    {!! $item['preview'] !!}

                                    <a data-href="{{ $item['link'] }}"
                                       class="@if(!$item['isDir'])file-name @else folder-name @endif" title="{{ $item['name'] }}">
                                        {{ $item['icon'] }} {{ basename($item['name']) }}
                                    </a>
                                </td>

                                <td class="action-row">
                                    <div class="btn-group btn-group-xs hide">
                                        <a class="btn btn-default file-rename" data-toggle="modal"
                                           data-target="#moveModal" data-name="{{ $item['name'] }}"><i
                                                class="fa fa-edit"></i></a>
                                        <a class="btn btn-default file-delete" data-path="{{ $item['name'] }}"><i
                                                class="fa fa-trash"></i></a>
                                        @unless($item['isDir'])
                                            <a target="_blank" href="{{ $item['download'] }}" class="btn btn-default"><i
                                                    class="fa fa-download"></i></a>
                                        @endunless
                                        <a class="btn btn-default" data-toggle="modal" data-target="#urlModal"
                                           data-url="{{ $item['url'] }}"><i class="fa fa-internet-explorer"></i></a>
                                    </div>

                                </td>
                                <td>{{ $item['time'] }}&nbsp;</td>
                                <td>{{ $item['size'] }}&nbsp;</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
            <!-- /.box-footer -->
            <!-- /.box-footer -->
        </div>
        <!-- /. box -->
    </div>
    <!-- /.col -->
</div>

<div class="modal fade" id="moveModal" tabindex="-1" role="dialog" aria-labelledby="moveModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="moveModalLabel">{{__('admin.remove_and_rename')}}</h4>
            </div>
            <form id="file-move">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="recipient-name" class="control-label">{{__('admin.path')}}:</label>
                        <input type="text" class="form-control" name="new"/>
                    </div>
                    <input type="hidden" name="path"/>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default btn-sm"
                            data-dismiss="modal">{{__('admin.close')}}</button>
                    <button type="submit" class="btn btn-primary btn-sm">{{__('admin.submit')}}</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="urlModal" tabindex="-1" role="dialog" aria-labelledby="urlModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="urlModalLabel">{{__('admin.uri')}}</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <input type="text" class="form-control"/>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">{{__('admin.close')}}</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="newFolderModal" tabindex="-1" role="dialog" aria-labelledby="newFolderModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="newFolderModalLabel">{{__('admin.new_folder')}}</h4>
            </div>
            <form id="new-folder">
                <div class="modal-body">
                    <div class="form-group">
                        <input type="text" class="form-control" name="name"/>
                    </div>
                    <input type="hidden" name="dir" value="{{ $url['path'] }}"/>
                    {{ csrf_field() }}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default btn-sm"
                            data-dismiss="modal">{{__('admin.close')}}</button>
                    <button type="submit" class="btn btn-primary btn-sm">{{__('admin.submit')}}</button>
                </div>
            </form>
        </div>
    </div>
</div>
