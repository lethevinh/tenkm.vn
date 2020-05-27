<ul class="comments__list">
    @foreach($post->publicComments as $comment)
        <li class="comment">
            <div class="comment__avatar">
                <img src="{{$comment->creator->image}}" class="img-responsive" alt="{{$comment->creator->name}}">
            </div>
            <div class="comment__content">
                <div class="comment__user">
                    {{$comment->creator->name}}
                </div>
                <div class="comment__date">
                    {{$comment->created_at->diffForHumans()}}
                </div>
                <div class="comment__message">
                    {{$comment->body_lb}}
                </div>
                <div class="comment__reply">
                    <ul class="comments__list">
                        @foreach($comment->publicComments as $commentSub)
                            <li class="comment">
                                <div class="comment__avatar">
                                    <img src="{{$commentSub->creator->image}}" class="img-responsive" alt="{{$commentSub->creator->name}}">
                                </div>
                                <div class="comment__content">
                                    <div class="comment__user">
                                        {{$commentSub->creator->name}}
                                    </div>
                                    <div class="comment__date">
                                        {{$commentSub->created_at->diffForHumans()}}
                                    </div>
                                    <div class="comment__message">
                                        {{$commentSub->body_lb}}
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                    @guest()
                    @else
                        <a class="comment__btn">({{count($comment->publicComments)}}) Trả lời</a>
                        <form style="display:none" class="comments__form" method="POST" action="{{route('comment.doComment', ['type' => 'comment', 'post' => $comment->id])}}">
                            @csrf
                            <input type="hidden" name="post_id" id="post_id_{{$post->id}}_{{$comment->id}}" value="{{$post->id}}">
                            <div class="form-group">
                                <label for="message" class="sr-only">Message (Required)</label>
                                <textarea name="message" class="form-control" rows="3" id="message{{$comment->id}}"
                                          placeholder="Ý kiến của bạn ..." minlength="10"></textarea>
                                <span class="help-block"></span>
                            </div>

                            <button type="submit" class="btn btn-accent">
                                Gửi
                            </button>
                        </form>
                    @endguest
                </div>
            </div>
        </li> <!-- .comment -->
    @endforeach
</ul> <!-- .comments__list -->
