<div class="single-feature style-two">
    <div class="thumb">
        <img src="{{$project->thumbnail}}" alt="img">
        <a href="#"><i class="fa fa-heart"></i></a>
    </div>
    <div class="details">
        <div class="details-wrap">
            <a href="{{$project->link}}" class="feature-logo">
                <img src="{{$project->thumbnail}}" alt="{{$project->title_lb}}">
            </a>
            <p class="author"><i class="fa fa-location-arrow"></i> {{$project->addressLabel}}</p>
            <h6 class="title"><a href="{{$project->link}}">{{$project->title_lb}}</a></h6>
            <p class="description">{{truncate($project->description_lb, 200, ' ...')}}</p>
            <h6 class="title" style="color: #ec665e;height: auto">{{$project->priceLabel}}</h6>
            <ul class="contact-list">
                <li><a class="phone" href="#"><i class="fa fa-phone"></i></a></li>
                <li><a class="message" href="#"><img src="/images/icons/8.png" alt="img"></a></li>
                <li><a class="btn btn-yellow" href="{{$project->link}}">{{tran('site.view_details')}}</a></li>
            </ul>
        </div>
    </div>
</div>
