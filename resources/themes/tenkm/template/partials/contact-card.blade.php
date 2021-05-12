<div class="widget widget-owner-info mt-lg-0 mt-5">
    <div class="owner-info text-center">
        <div class="thumb">
            @if($post->editor->phone)
                <img src="{{url('storage/'.$post->editor->avatar)}}" alt="img">
            @else
                <img src="{{url(option('logo'))}}" alt="img">
            @endif
        </div>
        <div class="details">
            @if($post->editor->name)
                <h6>{{$post->editor->name}}</h6>
            @else
                <h6>TenKM</h6>
            @endif
        </div>
    </div>
    <div class="contact">
        <h6>{{tran('site.contact')}}</h6>
        <form action="{{ route('home.doSubscribeProduct') }}" method="POST">
            @csrf
            <div class="rld-single-input">
                <input placeholder="{{tran('site.full_name')}}" value="{{old('subscribe_product_name')}}" type="text"
                       class="form-control {{ $errors->has('subscribe_product_name') ? 'error' : '' }}" name="subscribe_product_name" id="subscribe_product_name">
                <!-- Error -->
                @if ($errors->has('subscribe_product_name'))
                    <div class="error">
                        {{ $errors->first('subscribe_product_name') }}
                    </div>
                @endif
            </div>
            <div class="rld-single-input">
                <input placeholder="{{tran('site.email')}}" value="{{old('subscribe_product_email')}}" type="subscribe_product_email"
                       class="form-control {{ $errors->has('subscribe_product_email') ? 'error' : '' }}" name="subscribe_product_email"
                       id="subscribe_product_email">
                @if ($errors->has('subscribe_product_email'))
                    <div class="error">
                        {{ $errors->first('subscribe_product_email') }}
                    </div>
                @endif
            </div>
            <div class="rld-single-input">
                 <textarea placeholder="{{tran('site.content')}}"
                           class="form-control {{ $errors->has('subscribe_product_message') ? 'error' : '' }}"
                           name="subscribe_product_message" id="subscribe_product_message" minlength="20"
                           rows="2" style="    background: transparent;">{{old('subscribe_product_message')}}</textarea>
                @if ($errors->has('subscribe_product_message'))
                    <div class="error">
                        {{ $errors->first('subscribe_product_message') }}
                    </div>
                @endif
            </div>
            <input type="hidden" name="subscribe_product_link" value="{{$post->link}}">
            <button type="submit" class="btn btn-yellow">{{tran('site.subscribe')}}</button>
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
