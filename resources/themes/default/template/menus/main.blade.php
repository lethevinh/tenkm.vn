<ul class="nav navbar-nav navbar-left">
    @foreach($menu->children as $item)
        @if($item->children->count() > 0)
            <li class="dropdown @if($item->current()) active @endif" >
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                   aria-expanded="false">{{$item->title_lb}} <i class="ion-android-arrow-down"></i></a>
                <ul class="dropdown-menu">
                    @foreach($item->children as $sub)
                        <li @if($sub->current()) class="active" @endif>
                            <a href="{{$sub->url_lb}}">{{$sub->title_lb}}
                                @if($sub->current())
                                    <span class="sr-only">(current)</span>
                                @endif
                            </a>
                        </li>
                    @endforeach
                </ul>
            </li>
        @else
        <li @if($item->current()) class="active" @endif>
            <a href="{{$item->url_lb}}">{{$item->title_lb}}
                @if($item->current())
                    <span class="sr-only">(current)</span>
                @endif
            </a>
        </li>
        @endif
    @endforeach
{{--
    <li class="active">
        <a href="{{url('/')}}">{{$item->title_lb}} <span class="sr-only">(current)</span></a>
    </li>
    <li><a href="{{route('home.about')}}">Giới thiệu</a></li>
    <li class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
           aria-expanded="false">Các khóa học <i class="ion-android-arrow-down"></i></a>
        <ul class="dropdown-menu">
            <li><a href="{{route('course.index')}}">Courses page</a></li>
        </ul>
    </li>
    <li><a href="{{route('post.index')}}">Blog</a></li>
    <li class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
           aria-expanded="false">Pages <i class="ion-android-arrow-down"></i></a>
        <ul class="dropdown-menu">
            <li><a href="{{route('teachers.index')}}">Giảng viên</a></li>
            <li><a href="{{route('event.index')}}">Events</a></li>
        </ul>
    </li>
    <li><a href="{{route('home.contact')}}">Liên hệ</a></li>--}}
</ul>
