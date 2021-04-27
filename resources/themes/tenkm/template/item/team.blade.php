<div class="single-team">
    <div class="thumb">
        <img src="{{ $team->thumbnail }}" alt="{{$team->title_lb}}">
    </div>
    <div class="team-details">
        <h4>{{$team->title_lb}}</h4>
        <span>{{$team->description_lb}}</span>
        <ul>
            <li><a href="{{ $team->template_lb }}"><i class="fa fa-facebook"></i></a></li>
            <li><a href="{{ $team->content_lb }}"><i class="fa fa-twitter"></i></a></li>
            <li><a href="{{ $team->download_lb }}"><i class="fa fa-instagram"></i></a></li>
        </ul>
    </div>
</div>
