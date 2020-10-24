<ul class="nav navbar-nav navbar-left">
    <li class="active">
        <a href="{{url('/')}}">Trang chủ <span class="sr-only">(current)</span></a>
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
    <li><a href="{{route('home.contact')}}">Liên hệ</a></li>
</ul>
