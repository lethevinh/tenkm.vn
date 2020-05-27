
<div class="row">
    <div class="{{$viewClass['label']}}"><h4 class="pull-right">{!! $label !!}</h4></div>
    <div class="{{$viewClass['field']}}"></div>
</div>

<hr style="margin-top: 0px;">

<div id="has-many-{{$column}}" class="has-many-{{$column}}">

    <div class="has-many-{{$column}}-forms">

        @foreach($forms as $pk => $form)

            <div class="has-many-{{$column}}-form fields-group">
                <!-- Default box -->
                <div class="card collapsed-card">
                    <div class="card-header">
                        <h3 class="card-title">{{$form->fields()[0]->value()}}</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-warning btn-sm" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                                <i class="fa fa-plus"></i>{{ trans('admin.edit') }}</button>
                            @if($options['allowDelete'])
                                <button type="button" class="btn btn-danger btn-sm remove" data-toggle="tooltip" title="{{ trans('admin.remove') }}">
                                <i class="feather icon-trash"></i>{{ trans('admin.remove') }}</button>
                            @endif
                        </div>
                    </div>
                    <div class="card-body">
                        @foreach($form->fields() as $field)
                            {!! $field->render() !!}
                        @endforeach
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                    </div>
                    <!-- /.card-footer-->
                </div>
                <!-- /.card -->
                <hr>
            </div>

        @endforeach
    </div>


    <template class="{{$column}}-tpl">
        <div class="has-many-{{$column}}-form fields-group">

            {!! $template !!}

            <div class="form-group row">
                <label class="{{$viewClass['label']}} control-label"></label>
                <div class="{{$viewClass['field']}}">
                    <div class="remove btn btn-white btn-sm pull-right"><i class="feather icon-trash"></i>&nbsp;{{ trans('admin.remove') }}</div>
                </div>
            </div>
            <hr>
        </div>
    </template>

    @if($options['allowCreate'])
        <div class="form-group row">
            <label class="{{$viewClass['label']}} control-label"></label>
            <div class="{{$viewClass['field']}}">
                <div class="add btn btn-success btn-sm"><i class="feather icon-save"></i>&nbsp;{{ trans('admin.new') }}</div>
            </div>
        </div>
    @endif

</div>
