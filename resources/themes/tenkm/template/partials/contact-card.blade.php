<div class="widget widget-owner-info mt-lg-0 mt-5">
    <div class="owner-info text-center">
        <div class="thumb">
            <img src="{{url('storage/'.$post->creator->avatar)}}" alt="img">
        </div>
        <div class="details">
            <h6>{{$post->creator->name}}</h6>
        </div>
    </div>
    <div class="contact">
        <h6>{{tran('site.contact')}}</h6>
        <div class="rld-single-input">
            <input type="text" placeholder="{{tran('site.full_name')}}">
        </div>
        <div class="rld-single-input">
            <input type="text" placeholder="{{tran('site.email')}}">
        </div>
        <div class="rld-single-input">
            <input type="text" placeholder="{{tran('site.content')}}">
        </div>
        <a class="btn btn-yellow" href="#">{{tran('site.subscribe')}}</a>
    </div>
    <div class="contact-info">
        <h6 class="mb-3">{{tran('site.contact_info')}}</h6>
        <div class="media">
            <div class="media-left">
                <img src="/images//icons/1.png" alt="img">
            </div>
            <div class="media-body">
                <p>{{tran('site.address')}}</p>
                <span>{{option('address')}}</span>
            </div>
        </div>
        <div class="media">
            <div class="media-left">
                <i class="fa fa-phone"></i>
            </div>
            <div class="media-body">
                <p>{{tran('site.phone')}}</p>
                <span>{{option('phone')}}</span>
            </div>
        </div>
        <div class="media mb-0">
            <div class="media-left">
                <i class="fa fa-envelope"></i>
            </div>
            <div class="media-body">
                <p>Email</p>
                <span>{{option('email')}}</span>
            </div>
        </div>
    </div>
</div>
