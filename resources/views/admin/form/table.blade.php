
<div class="row form-group">
    <div class="{{$viewClass['label']}} "><label class="control-label pull-right">{!! $label !!}</label></div>
    <div class="{{$viewClass['field']}}">
        @include('admin::form.error')

        <span name="{{$column}}"></span> {{-- 用于显示错误信息 --}}

        <div id="has-many-{{$column}}-{{$fieldId}}" >
            <table class="table table-has-many has-many-{{$column}}-{{$fieldId}}">
                <thead>
                <tr>
                    @foreach($headers as $header)
                        <th>{{ $header }}</th>
                    @endforeach

                    <th class="hidden"></th>

                    @if($options['allowDelete'])
                        <th></th>
                    @endif
                </tr>
                </thead>
                <tbody class="has-many-{{$column}} has-many-{{$column}}-{{$fieldId}}-forms">
                @foreach($forms as $pk => $form)
                    <tr class="has-many-{{$column}}-{{$fieldId}}-form fields-group">

                        <?php $hidden = ''; ?>

                        @foreach($form->fields() as $field)

                            @if (is_a($field, \Dcat\Admin\Form\Field\Hidden::class))
                                <?php $hidden .= $field->render(); ?>
                                @continue
                            @endif

                            <td>{!! $field->setLabelClass(['hidden'])->width(12, 0)->render() !!}</td>
                        @endforeach

                        <td class="hidden">{!! $hidden !!}</td>

                        @if($options['allowDelete'])
                            <td class="form-group">
                                <div>
                                    <div class="x-remove btn btn-white btn-sm pull-right"><i class="feather icon-trash">&nbsp;</i>{{ trans('admin.remove') }}</div>
                                </div>
                            </td>
                        @endif
                    </tr>
                @endforeach
                </tbody>
            </table>

            <template class="{{$column}}-{{$fieldId}}-tpl">
                <tr class="has-many-{{$column}}-{{$fieldId}}-form fields-group">

                    {!! $template !!}

                    <td class="form-group">
                        <div>
                            <div class="x-remove btn btn-white btn-sm pull-right"><i class="feather icon-trash">&nbsp;</i>{{ trans('admin.remove') }}</div>
                        </div>
                    </td>
                </tr>
            </template>

            @if($options['allowCreate'])
                <div class="form-group row m-t-10">
                    <div class="{{$viewClass['field']}}" style="margin-top: 8px">
                        <div class="x-add btn btn-success btn-sm"><i class="feather icon-save"></i>&nbsp;{{ trans('admin.new') }}</div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

{{--<hr style="margin-top: 0px;">--}}
