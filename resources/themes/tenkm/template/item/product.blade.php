<div class="single-feature">
    <div class="thumb">
        <img src="{{$product->thumbnail}}" alt="img">
        <a href="{{$product->link}}"><i class="fa fa-heart"></i></a>
    </div>
    <div class="details">
        <a href="{{$product->link}}" class="feature-logo">
            <img src="{{$product->thumbnail}}" alt="icons">
        </a>
        <p class="author"><i class="fa fa-user"></i> {{$product->creator->name}}</p>
        <h6 class="title"><a href="{{$product->link}}">{{$product->title_lb}}</a></h6>
        <h6 class="price">{{$product->priceLabel}}</h6>
        <ul class="info-list">
            <li><i class="fa fa-bed"></i> {{$product->bedroom_nb}}</li>
            <li><i class="fa fa-bath"></i> {{$product->bathroom_nb}}</li>
            <li><img src="/images/icons/7.png" alt="img"> {{$product->area_nb}} m²</li>
        </ul>
        <ul class="contact-list">
            <li><a class="phone" href="tel:{{$product->creator->phone}}"><i class="fa fa-phone"></i></a></li>
            <li><a class="message" href="#"><img src="/images/icons/8.png" alt="img"></a></li>
            <li><a class="btn btn-yellow" href="{{$product->link}}">{{__('site.view_details')}}</a></li>
        </ul>
    </div>
</div>
