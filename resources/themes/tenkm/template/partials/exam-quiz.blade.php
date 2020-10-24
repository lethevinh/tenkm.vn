<div class="container">
        <div class="row">
            <div class="col-sm-6 col-md-12">
                <div class="course__body">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="course__title question-title">
                                {{$exam->title_lb}}
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div id="question-clock" style="float: left"></div>
                            <button class="btn btn-danger btn-question-quiz-stop" style="float: right">{{__('site.exam_stop')}}</button>
                        </div>
                    </div>
                    <p>&nbsp;</p>
                    <form id="question-quiz" data-course="{{$course->id}}" data-exam="{{$exam->id}}" data-questions="{{$exam->questions->count()}}">
                        @foreach($exam->questions as $key => $question)
                            <div class="row">
                            <div class="col-sm-12 col-md-12">
                                <div class="question">{{$key + 1}}. {{$question->title_lb}}</div>
                            </div>
                            <div class="col-sm-6 col-md-12">
                                <ul class="answer">
                                    @foreach($question->chooses as $choose)
                                        <li>
                                            <input type="radio" value="{{$choose->id}}" id="choose{{$choose->id}}" name="{{$question->id}}" class="form-group">&nbsp;
                                            <label for="choose{{$choose->id}}">{{$choose->grade_fl}} {{$choose->title_lb}}</label>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        @endforeach
                        <div class="row">
                            <div class="col-md-12">
    {{--                            <button class="btn btn-warning" style="float: left">{{__('site.exam_pre')}}</button>--}}
                                <button class="btn btn-warning btn-question-quiz-submit" style="float: right">{{__('site.exam_submit')}}</button>
    {{--                            <button class="btn btn-primary" style="float: right;margin-right: 10px">{{__('site.exam_next')}}</button>--}}
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div> <!-- / .row -->
    </div> <!-- / .container -->
