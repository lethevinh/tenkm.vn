<div id="{{ $containerId }}" class="{{$viewClass['form-group']}} {!! !$errors->has($errorKey) ? '' : 'has-error' !!}">

    <label for="{{$column}}" class="{{$viewClass['label']}} control-label">{!! $label !!}</label>

    <div class="{{$viewClass['field']}}">

        @include('admin::form.error')

        <input name="{{ $name }}" id="{{ $id }}" type="hidden" value="{{$value}}" />
        <div class="web-uploader {{ $fileType }} media-field">
            <div class="queueList">
                <div class="placeholder dnd-area">
                    <div class="file-picker"></div>
                    <p>{{trans('admin.uploader.drag_file')}}</p>
                </div>
            </div>
            <div class="statusBar" style="display:block;">
                <div class="info"></div>
                <div class="btns">
                    <button class="btn btn-primary" id="media-{{$id}}">
                        <i class="feather icon-aperture"></i>
                        {{__('site.media')}}
                    </button>
                </div>
            </div>
        </div>

        @include('admin::form.help-block')

    </div>
</div>
