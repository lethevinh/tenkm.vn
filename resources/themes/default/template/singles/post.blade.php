@extends('layouts.full')
@section('title', $post->title_lb)
@section('id_body', 'blog-item__page')
@section('content')
    <!-- section home -->
    <section class="section__home">
        <div class="container home__body">
            <div class="row">
                <div class="col-sm-12">
                    <div class="home__content">

                        <!-- Heading -->
                        <h1 class="home__heading">
                            {{$post->title_lb}}
                        </h1>

                        <!-- Breadcrumbs -->
                        <ol class="breadcrumb">
                            <li><a href="{{route('home.show')}}">{{ __('site.home') }}</a></li>
                            @if($post->categories->count() > 0)
                                <li><a href="{{$post->categories[0]->link}}">{{ $post->categories[0]->title_lb }}</a></li>
                            @endif
                            <li class="active"> {{$post->title_lb}}</li>
                        </ol>

                    </div> <!-- / .home__content -->
                </div>
            </div> <!-- / .row -->
        </div> <!-- / .container -->

        <!-- Background image -->
        <div class="home__bg"></div>
    </section> <!-- .section__home -->

    <!-- section blog-item -->
    <section class="section__blog-item">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <div class="section_title__body">
                        <div class="section__subtitle dark__subtitle">
                            {{$post->updated_at->format('H:m d/m')}} <span>{{$post->updated_at->format('Y')}}</span>
                        </div>
                        <h2 class="blog_item__title dark__title">
                            {{$post->title_lb}}
                        </h2>
                        <p class="blog_item__tags">
                            <i class="ion-ios-pricetags" aria-hidden="true"></i>
                            @foreach($post->categories as $category)
                                <a href="{{$category->link}}">{{$category->title_lb}}</a>
                            @endforeach
                        </p> <!-- / .blog_item__tags -->
                    </div> <!-- / .section_title__body  -->
                    <div class="blog_item__abstract">
                        {{$post->description_lb}}
                    </div>
                </div>
            </div> <!-- / .row -->
            <div class="row">
                <div class="col-sm-12">
                    <div class="blog_item__img">
                        <img src="{{$post->image_lb}}" class="img-responsive" alt="...">
                    </div>
                </div>
            </div> <!-- / .row -->
            <div class="row">
                <div class="col-sm-12">
                    <div class="blog_item__text">
                        {!! $post->content_lb !!}
                    </div>
                </div>
            </div> <!-- / .row -->
            <div class="row">
                <div class="col-sm-12">
                    <div class="blog_item__info">
                        <div class="blog_item__author">
                            Đăng bởi: <a href="#">{{$post->creator->name}}</a>
                        </div>
                        <ul class="blog_item__share">
                            <li class="social-icons__item">{{__('site.share')}}:</li>
                            <li class="social-icons__item">
                                <a href="https://twitter.com/intent/tweet?text={{$post->title_lb}}&url={{$post->title_lb}}">
                                    <i class="icon ion-social-twitter" aria-hidden="true"></i>
                                </a>
                            </li>
                            <li class="social-icons__item">
                                <a href="https://www.facebook.com/sharer.php?u={{$post->link}}">
                                    <i class="icon ion-social-facebook" aria-hidden="true"></i>
                                </a>
                            </li>
                            <li class="social-icons__item">
                                <a href="#">
                                    <i class="icon ion-social-googleplus" aria-hidden="true"></i>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div> <!-- / .row -->
            <div class="row">
                <div class="col-sm-12">
                    <nav aria-label="...">
                        <ul class="pager">
                            @if($post->prev())
                            <li class="previous">
                                <a href="{{$post->prev()->link?? ''}}"><i class="ion-android-arrow-back"></i> Bài viết trước</a>
                            </li>
                            @endif
                                @if($post->next())
                            <li class="next"><a href="{{$post->next()->link?? ''}}">Bài tiếp theo <i class="ion-android-arrow-forward"></i></a>
                            </li>
                                @endif
                        </ul>
                    </nav>
                </div>
            </div> <!-- / .row -->
            <div class="row">
                <div class="col-xs-12">
                    <div class="section__subtitle blog_item__subtitle">
                        Bài viết <span>yêu thích</span>
                    </div>
                </div>
            </div> <!-- / .row -->
            <div class="row">s
                @if($post->categories->count() > 0)
                @foreach($post->categories[0]->posts()->limit(3)->get() as $rlPost)
                    @if($rlPost->id !== $post->id)
                        <div class="col-sm-4">
                            @include('item.post-related', ['post' => $rlPost])
                        </div>
                    @endif
                    @endforeach
                @endif
            </div> <!-- / .row -->

            <div class="row">
                <div class="col-sm-12">
                    @guest()
                        <div class="section__subtitle blog_item__subtitle">
                            Hãy <a href="#signinModal" data-toggle="modal">đăng nhập </a> để bình luận
                        </div>
                    @else
                        <div class="section__subtitle blog_item__subtitle">
                            Ý kiến <span>của bạn</span>
                        </div>
                        <form class="comments__form" method="POST" action="{{route('comment.doComment', ['type' => 'post', 'post' => $post->id])}}">
                            @csrf
                            <input type="hidden" name="post_id" id="post_id" value="{{$post->id}}">
                            <div class="form-group">
                                <label for="message" class="sr-only">Message (Required)</label>
                                <textarea name="message" class="form-control" rows="3" id="message"
                                          placeholder="Ý kiến của bạn ..." minlength="30"></textarea>
                                <span class="help-block"></span>
                            </div>

                            <button type="submit" class="btn btn-accent">
                                Gửi
                            </button>
                        </form>
                    @endguest
                </div>
            </div> <!-- / .row -->
            <div class="row">
                <div class="col-xs-12">
                    <div class="section__subtitle blog_item__subtitle">
                        <span>{{count($post->publicComments)}}</span> Bình luận
                    </div>
                    <div class="comments">
                        @include('collection.comment',['post' => $post, 'type' => 'post'])
                    </div> <!-- .comments -->
                </div>
            </div> <!-- / .row -->

        </div> <!-- / .container -->
    </section> <!-- .section__blog-item -->
@endsection
