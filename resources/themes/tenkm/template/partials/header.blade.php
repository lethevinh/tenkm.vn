<!-- navbar start -->
<div class="navbar-area">
    <nav class="navbar navbar-area navbar-expand-lg">
        <div class="container nav-container">
            <div class="responsive-mobile-menu">
                <button class="menu toggle-btn d-block d-lg-none" data-toggle="collapse" data-target="#realdeal_main_menu"
                        aria-expanded="false" aria-label="Toggle navigation">
                    <span class="icon-left"></span>
                    <span class="icon-right"></span>
                </button>
            </div>
            <div class="logo">
                <a href="{{route('home.show')}}">
                    <img src="{{url(option('logo'))}}" alt="logo">
                </a>
            </div>
            <div class="collapse navbar-collapse" id="realdeal_main_menu">
                <x-menu name="main"></x-menu>
            </div>
        </div>
    </nav>
</div>
<!-- navbar end -->
