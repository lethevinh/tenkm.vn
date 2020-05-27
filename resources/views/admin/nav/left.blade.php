<ul class="nav navbar-nav">
    <li class="dropdown dropdown-language nav-item">
        <a class="nav-link" target="_blank" href="{{route('home.show')}}">
            <i class="ficon fa fa-eye text-primary"></i>
            <span class="selected-language">{{__('admin.view')}} {{__('site.home')}}</span>
        </a>
    </li>
</ul>
<ul class="nav navbar-nav">
    <li class="dropdown dropdown-language nav-item">
        <a class="dropdown-toggle nav-link" href="#" id="dropdown-flag" data-toggle="dropdown">
            <i class="ficon feather icon-plus-circle text-primary"></i>
            <span class="selected-language">{{__('site.add')}} {{__('admin.new')}}</span>
        </a>
        <ul class="dropdown-menu" aria-labelledby="dropdown-flag">
            <li class="dropdown-item"  data-language="en">
                <a href="{{route('posts.create')}}"><i class="fa fa-newspaper-o"></i> {{__('site.news')}}</a>
            </li>
        </ul>
    </li>
</ul>
