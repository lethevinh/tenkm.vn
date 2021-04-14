<div class="widget widget-owner-info mt-lg-0 mt-5">
    <div class="owner-info text-center">
        <div class="thumb">
            <img src="{{url('storage/'.$post->editor->avatar)}}" alt="img">
        </div>
        <div class="details">
            <h6>{{$post->editor->name}}</h6>
        </div>
    </div>
    <div class="contact">
        <h6>{{tran('site.contact')}}</h6>
        <form action="">
            <div class="rld-single-input">
                <input type="text" placeholder="{{tran('site.full_name')}}">
            </div>
            <div class="rld-single-input">
                <input type="text" placeholder="{{tran('site.email')}}">
            </div>
            <div class="rld-single-input">
                <input type="text" placeholder="{{tran('site.content')}}">
            </div>
            <button class="btn btn-yellow">{{tran('site.subscribe')}}</button>
        </form>
    </div>
    <div class="contact-info">
        <h6 class="mb-3">{{tran('site.contact_info')}}</h6>
        <div class="media">
            <div class="media-left">
                <img src="/images//icons/1.png" alt="img">
            </div>
            <div class="media-body">
                <p>{{tran('site.address')}}</p>
                <span>
                    @if($post->editor->address)
                        {{$post->editor->address}}
                    @else
                        {{option('address')}}
                    @endif
                </span>
            </div>
        </div>
        <div class="media">
            <div class="media-left">
                <i class="fa fa-phone"></i>
            </div>
            <div class="media-body">
                <p>{{tran('site.phone')}}</p>
                <span>
                    @if($post->editor->phone)
                        {{$post->editor->phone}}
                    @else
                        {{option('phone')}}
                    @endif
                </span>
            </div>
        </div>
        <div class="media mb-0">
            <div class="media-left">
                <i class="fa fa-envelope"></i>
            </div>
            <div class="media-body">
                <p>Email</p>
                <span>
                    @if($post->editor->email)
                        {{$post->editor->email}}
                    @else
                        {{option('email')}}
                    @endif
                </span>
            </div>
        </div>
    </div>
</div>
