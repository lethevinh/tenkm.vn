<div class="form-lectures {{$viewClass['form-group']}} {!! !$errors->has($errorKey) ? '' : 'has-error' !!}">

    <label for="{{$id}}" class="{{$viewClass['label']}} control-label">{{$label}}</label>

    <div class="{{$viewClass['field']}} ">
        @include('admin::form.error')
        @if($value)
            <div class="dd" id="lecture_{{$value}}">
                <ol class="dd-list">
                    <li class="dd-item" data-id="{{$value}}">
                        <ol class="dd-list">
                            @foreach($lectures as $lecture)
                                <li class="dd-item lecture_item_wrapper" data-id="{{$lecture->id}}">
                                    <div class="dd-handle lecture_item">
                                        <p class="pull-left lecture_title">{{$lecture->title_lb}}</p>
                                        <span class="pull-right dd-nodrag">
                                            <a data-action="delete" data-url="{{admin_base_path('lectures/'.$lecture->id)}}" class="pull-right btn-lecture btn-lecture-rm">
                                                <i class="feather icon-trash">&nbsp;</i>
                                            </a>
                                            <a  data-url="{{admin_base_path('lectures/'.$lecture->id.'/edit?course_id='.$value.'&action=lecture_by_course' )}}" class="pull-right btn-lecture btn-edit-lecture-{{$lecture->id}}" style="right: 45px">
                                                <i class="feather icon-edit-1">&nbsp;</i>
                                            </a>
                                        </span>
                                    </div>
                                </li>
                            @endforeach
                        </ol>
                    </li>
                </ol>
            </div>
            <div class="form-group row">
                <label class="col-md-2  text-capitalize control-label"></label>
                <div class="col-md-10">
                    <div data-url="{{admin_base_path('lectures/create')}}?course_id={{$value}}&action=lecture_by_course" class="btn btn-warning btn-sm pull-right create-lecture">
                        <i class="fa fa-plus-circle">&nbsp;</i>
                        {{ __('site.add') . __('admin.lecture')}}
                    </div>
                    <div data-nestable-selector="lecture_{{$value}}" class="btn btn-white btn-sm pull-right btn-nestable-save" style="margin-right: 20px">
                        <i class="fa fa-plus-circle">&nbsp;</i>
                        {{ __('admin.save') .' '. __('admin.sort')}}
                    </div>
                </div>
            </div>
        @else
            <span class="help-block">
                 <i class="fa fa-question-circle-o" ></i>
                Hãy lưu section để có thể add lecture
            </span>
        @endif
        @include('admin::form.help-block')
    </div>
</div>
