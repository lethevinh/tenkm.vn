<div class="single-feature">
    <div class="thumb">
        <img src="{{$product->thumbnail}}" alt="img">
        <a href="#"><i class="fa fa-heart"></i></a>
    </div>
    <div class="details">
        <a href="#" class="feature-logo">
            <img src="/images/icons/l1.png" alt="icons">
        </a>
        <p class="author"><i class="fa fa-user"></i> {{$product->creator->name}}</p>
        <h6 class="title">
            <a href="{{$product->link}}">{{$product->title_lb}}</a>
        </h6>
        <h6 class="price">$350/mo</h6><del>$790/mo</del>
        <ul class="info-list">
            <li><i class="fa fa-bed"></i> 05 Bed</li>
            <li><i class="fa fa-bath"></i> 02 Bath</li>
            <li><i class="fa fa-square-o"></i> 1898 sq.</li>
        </ul>
        <ul class="contact-list">
            <li><a class="phone" href="#"><i class="fa fa-phone"></i></a></li>
            <li><a class="message" href="#"><i class="fa fa-comment-o"></i></a></li>
            <li><a class="btn btn-yellow" href="property-details.html">View Details</a></li>
        </ul>
    </div>
</div>
