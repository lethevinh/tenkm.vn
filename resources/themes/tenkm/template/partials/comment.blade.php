<!-- comments-area-start -->
<div class="comments-area">
    <h4 class="comments-title">{{tran('site.comments')}} ({{count($post->publicComments)}})</h4>
    @include('collection.comment',['post' => $post, 'type' => 'post'])
</div>
<!-- comments-area-end -->
<!-- blog-comment-area start -->
<div class="blog-comment-area pd-bottom-100">
    @guest()
        <div class="section__subtitle blog_item__subtitle">
            Hãy <a href="#signinModal" data-toggle="modal">đăng nhập </a> để bình luận
        </div>
    @else
        <form class="rld-comment-form">
            <h4 class="single-page-small-title">Write A Coment.</h4>
            <div class="row">
                <div class="col-lg-6 col-md-6">
                    <div class="rld-single-input">
                        <input type="text" placeholder="Name">
                    </div>
                </div>
                <div class="col-lg-6 col-md-6">
                    <div class="rld-single-input">
                        <input type="text" placeholder="Email">
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="rld-single-input">
                        <textarea rows="10" placeholder="Message"></textarea>
                    </div>
                </div>
                <div class="col-12">
                    <a class="btn btn-yellow" href="#">Send Comment</a>
                </div>
            </div>
        </form>
    @endguest
</div>
<!-- blog-comment-area start -->
