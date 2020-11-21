<div class="single-feature style-two">
    <div class="thumb">
        <img src="{{$post->thumbnail}}" alt="img">
        <a href="#"><i class="fa fa-heart"></i></a>
    </div>
    <div class="details">
        <div class="details-wrap">
            <a href="{{$post->link}}" class="feature-logo">
                <img src="{{$post->thumbnail}}" alt="{{$post->title_lb}}">
            </a>
            <p class="author"><i class="fa fa-location-arrow"></i> {{$post->addressLabel}}</p>
            <h6 class="title"><a href="{{$post->link}}">{{$post->title_lb}}</a></h6>
            <p class="description">{{truncate($post->description_lb, 200, ' ...')}}</p>
            <ul class="info-list">
                <li><i class="fa fa-building"></i> {{$post->block_nb}} {{trans('site.blocks')}}</li>
                <li><i class="fa fa-key"></i> {{$post->department_nb}} {{trans('site.apartments')}}</li>
                <li><img src="/images/icons/7.png" alt="img"> {{$post->area_nb}} m²</li>
            </ul>
            <ul class="contact-list">
                <li><a class="phone" href="#"><i class="fa fa-phone"></i></a></li>
                <li><a class="message" href="#"><img src="/images/icons/8.png" alt="img"></a></li>
                <li><a class="btn btn-yellow" href="{{$post->link}}">{{__('site.view_details')}}</a></li>
            </ul>
        </div>
    </div>
</div>
