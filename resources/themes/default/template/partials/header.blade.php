<!-- Back to top button
    ================================================== -->
<a id="back-to-top" href="#section__home" class="btn btn-primary back-to-top" role="button"
   title="Click to return on the top page" data-toggle="tooltip" data-placement="left">
    <i class="ion-android-arrow-up"></i>
</a>

<!-- PRELOADER
================================================== -->
@include('partials.loading')
<!-- Navbar
================================================== -->
<nav class="navbar navbar-default navbar-fixed-top">
    <div class="container">

        <!-- Header -->
        <div class="navbar-header">

            <!-- Collapse toggle -->
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar__collapse"
                    aria-expanded="false">
                <span class="sr-only">Menu</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>

            <!-- Logo -->
            <a class="navbar-brand" href="{{url('/')}}">
                <img src="/assets/img/Logo_Edureal_Small2.png" class="img-responsive" alt="Edureal">
            </a>

        </div> <!-- / .navbar-header -->

        <!-- Links -->
        <div class="collapse navbar-collapse" id="navbar__collapse">
            <x-menu name="main"  template="home"></x-menu>
            <ul class="nav navbar-nav navbar-right @guest nav__profile_bar @endif">
                @guest
                    <li><a href="#signinModal" data-toggle="modal"><i class="ion-log-in"></i> {{ __('admin.login') }}</a></li>
                    <li><a href="#signupModal" data-toggle="modal"><i class="ion-android-person"></i> {{ __('admin.register') }}</a></li>
                @else
                    <li class="dropdown">
                        <a href="{{ Auth::user()->link }}" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                            <i class="ion-android-person"></i> {{ Auth::user()->name }} <i class="ion-android-arrow-down"></i>
                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                <a class="dropdown-item" href="{{ Auth::user()->link}}">
                                    {{ __('admin.profile') }}
                                </a>
                                <a class="dropdown-item" href="{{ route('user.profile.update', ['user' => Auth::user()])}}">
                                    {{ __('admin.update_profile') }}
                                </a>
                                @if(Auth::user()->type_lb === 'teacher')
                                    <a class="dropdown-item" href="{{ route('teachers.report', ['user' => Auth::user()])}}">
                                        {{ __('admin.sale_report') }}
                                    </a>
                                @endif
                                <a class="dropdown-item btn-logout">
                                    {{ __('admin.logout') }}
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </li>
                        </ul>
                    </li>
                @endif
                <li class="hidden-xs">
                    <!-- Search toggle -->
                    <a href="#" class="navbar-search__toggle">
                        <i class="ion-search"></i>
                    </a>
                    <!-- Search form -->
                    <div class="navbar-search">
                        <form action="{{route('home.search')}}" method="GET">
                            <!-- Input -->
                            <div class="navbar-search__box">
                                <div class="input-group">
                                    <input type="text" name="s" class="form-control" placeholder="Tìm kiếm">
                                    <span class="input-group-btn">
                                        <button type="submit" class="btn btn-accent"><i class="ion-search"></i></button>
                                    </span>
                                </div>
                            </div> <!-- / .navbar-search__box -->

                        </form>
                    </div> <!-- / .navbar-search -->

                </li>
            </ul>
        </div><!-- /.navbar-collapse -->

    </div><!-- /.container -->
</nav>

<!-- CONTENT
  ================================================== -->
@include('partials.login')
@include('partials.register')
