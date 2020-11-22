<ul class="comment-list">
    @foreach($post->publicComments as $comment)
        <li>
            <div class="single-comment-wrap">
                <div class="thumb">
                    <img src="{{url('storage/'.$post->creator->avatar)}}" alt="img">
                </div>
                <div class="content">
                    <h4 class="title">{{$comment->creator->name}}</h4>
                    <p>{{$comment->body_lb}}</p>
{{--                    <a href="#" class="like"><i class="fa fa-heart-o"></i>Like 235</a>--}}
{{--                    <a href="#" class="reply">Reply</a>--}}
                </div>
            </div>
        </li>
    @endforeach
</ul>
