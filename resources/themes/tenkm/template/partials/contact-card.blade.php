<div class="widget widget-owner-info mt-lg-0 mt-5">
    <div class="owner-info text-center">
        <div class="thumb">
            <img src="{{url('storage/'.$post->creator->avatar)}}" alt="img">
        </div>
        <div class="details">
            <h6>{{$post->creator->name}}</h6>
            <span class="designation">Building Owner</span>
            <p class="reviews"><i class="fa fa-star"></i><span>4.8</span> 70 Review</p>
        </div>
    </div>
    <div class="contact">
        <h6>{{__('site.contact')}}</h6>
        <div class="rld-single-input">
            <input type="text" placeholder="{{__('site.full_name')}}">
        </div>
        <div class="rld-single-input">
            <input type="text" placeholder="{{__('site.email')}}">
        </div>
        <div class="rld-single-input">
            <input type="text" placeholder="{{__('site.content')}}">
        </div>
        <a class="btn btn-yellow" href="#">{{__('site.subscribe')}}</a>
    </div>
    <div class="contact-info">
        <h6 class="mb-3">{{trans('site.contact_info')}}</h6>
        <div class="media">
            <div class="media-left">
                <img src="/images//icons/1.png" alt="img">
            </div>
            <div class="media-body">
                <p>{{trans('site.address')}}</p>
                <span>{{$post->addressLabel}}</span>
            </div>
        </div>
        <div class="media">
            <div class="media-left">
                <i class="fa fa-phone"></i>
            </div>
            <div class="media-body">
                <p>{{trans('site.phone')}}</p>
                <span>+00 111 222 333</span>
            </div>
        </div>
        <div class="media mb-0">
            <div class="media-left">
                <i class="fa fa-envelope"></i>
            </div>
            <div class="media-body">
                <p>Email</p>
                <span>info@example.com</span>
            </div>
        </div>
    </div>
</div>
