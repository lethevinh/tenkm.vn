@if(count($locales) > 2)
<div class="btn-group pull-right btn-mini" style="margin-right: 5px">
    <button type="button" class="btn btn-sm btn-warning">{{$list}}</button>
    <button type="button" class="btn btn-sm btn-warning dropdown-toggle dropdown-hover dropdown-icon" data-toggle="dropdown">
        <span class="sr-only">Toggle Dropdown</span>
        <div class="dropdown-menu" role="menu">
            @foreach($locales as $locale)
                <a class="dropdown-item" href="#">
                    <img src="{{asset('images/icons/'.$locale.'.svg')}}" width="30px" height="20x"/>
                    {{$locale}}
                </a>
            @endforeach
        </div>
    </button>
</div>
@else
    <div class="btn-group pull-right btn-mini" style="margin-right: 5px">
        @foreach($translations as $translation)
            <a href="{{$translation->edit}}" class="btn btn-sm">
                    <i class="fa fa-language"></i><span class="d-none d-sm-inline"> {{trans('site.'.$translation->language_lb)}}</span>
            </a>
        @endforeach
    </div>
@endif
