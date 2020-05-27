<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Lecture;
use App\Http\Resources\Question;
use App\Http\Resources\SectionResource;
use App\Http\Resources\StudentResource;
use App\Models\Choose;
use App\Models\Course;
use App\Http\Resources\Course as CourseResource;
use App\Models\Exam;
use App\Models\Student;
use App\Models\User;
use App\Traits\ApiResponsable;

class CourseController extends Controller
{
    use ApiResponsable;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    public function detail($id)
    {
        $course = Course::where('id', $id)
            ->firstorFail();
        $course->currentStudent = $student = $course->student(request()->user());
        $data = [
            'student' => StudentResource::make($student),
        ];
        $data['course'] = CourseResource::make($course);
        $lectures = [];
        if ($course->currentStudent) {
            $lectures = $course->lectures();
            $data['exam'] = \App\Http\Resources\Exam::make($course->exams[0]);
        }
        request()->currentCourse = $course;
        $data['lectures'] = Lecture::collection($lectures->get());
        return $this->respondOk('', $data);
    }

    public function detailSection($id)
    {
        $course = Course::where('id', $id)
            ->firstorFail();
        $course->currentStudent = $student = $course->student(request()->user());
        $data = [
            'student' => StudentResource::make($student),
        ];
        $data['course'] = CourseResource::make($course);
        request()->currentCourse = $course;
        $sections = $course->sections()
            ->published()
            ->with(['lectures' => function ($query) {
                $query->where('status_sl', 'public');
            }]);
        if ($course->currentStudent) {
            $sections->with(['lectures.resources.sourceable' => function ($query) {
                $query->where('status_sl', 'public');
            }]);
        }

        $data['sections'] = SectionResource::collection($sections->get());
        return $this->respondOk('', $data);
    }

    public function renderQuestionQuiz($id)
    {
        $course = Course::find(request()->input('course_id'));
        $exam = Exam::where('id', $id)->with('questions.chooses')->first();
        return view('partials.exam-quiz', ['exam' => $exam, 'course' => $course]);
    }

    public function updateVideoProgress($id, $type){
        $course = Course::where('id', $id)
            ->firstorFail();
        $course->currentStudent = $student = $course->student(request()->user());
        $progress = Student::startProgress($course);
        $finishLecture = false;
        if (request()->has('params') && $video = request()->input('params')) {
            if($student->pivot->extra_lb) {
                $extra = json_decode($student->pivot->extra_lb, true);
                $progress = isset($extra['progress']) ? $extra['progress'] : $progress;
                if ($progress) {
                    if (isset($video['uuid'])) {
                        $progress['video'] = $video['uuid'];
                    }
                    if (isset($video['exam'])) {
                        $progress['exam'] = $video['exam'];
                    }
                    if (isset($video['lecture'])) {
                        if (!in_array($video['lecture'], $progress['lectures'])) {
                            $progress['lectures'][] = $video['lecture'];
                        }
                        $progress['lecture'] = $video['lecture'];
                    }
                    if (isset($video['section'])) {
                        if (!in_array($video['section'], $progress['sections'])){
                            $progress['sections'][] = $video['section'];
                        }
                        $progress['section'] = $video['section'];
                    }
                    $student->progressCourse($course, ['progress' => $progress]);
                    if ($student->pivot->status_sl === 'passed') {
                        return $this->respondWithSuccess('finish_course', ['result_course' => 'passed', 'student' => StudentResource::make($student)]);
                    }
                    $countLecture = count($progress['lectures']);
                    $countLectureCourse = $course->lectures->count();
                    $finishLecture = $countLecture == $countLectureCourse;
                }
            }
        }
        return $this->respondWithSuccess('update_progress_success', [
            'student' => StudentResource::make($student),
            'finishLecture' => $finishLecture
        ]);
    }
    public function submitQuestionQuiz($id)
    {
        $exam = Exam::where('id', $id)->with('questions.chooses')->firstorFail();
        if ($exam) {
            response()->json()->status(404);
        }
        $user = request()->user();
        $input = request()->input('data');
        $point = 0;
        $totalPoint = 0;
        $input = collect($input);
        $answers = $input->pluck('value', 'name')->toArray();
        $resultRight = [];

        $exam->questions->each(function ($question) use ($answers, &$point, &$totalPoint, &$resultRight) {
            $question->chooses->each(function ($choose) use ($question, $answers, &$point, &$totalPoint, &$resultRight) {
                if (isset($answers[$question->id])) {
                    $answer = Choose::find($answers[$question->id]);
                    if ($answer && $choose->id === $answer->id && intval($answer->grade_fl) > 0) {
                        $point += intval($answer->grade_fl);
                    }
                }
                if (intval($choose->grade_fl) > 0) {
                    $totalPoint += intval($choose->grade_fl);
                    $resultRight[] = [$question->id => $choose->id];
                }
            });
        });

        $result = 'fail';
        if (($point / $totalPoint) > 0.7) {
            $result = 'pass';
        }
        $extra = [
            'answers' => $answers,
            'point' => $point,
            'result' => $result,
            'resultRight' => $resultRight
        ];
        $course = Course::findOrFail(request()->input('course_id'));
        $student = $course->student($user);
        if ($student && $student->pivot->extra_lb) {
            $progress = json_decode($student->pivot->extra_lb, true)['progress'];
            $progress['exam_result'] = $result;
            $student->progressCourse($course, ['progress' => $progress]);
        }

        if ($user->exams()->wherePivot('examinable_id', $user->id)->get()->isNotEmpty()) {
            $user->exams()->updateExistingPivot($exam->id, ['extra_lb' => json_encode($extra)]);
        } else {
            $user->attachExam($exam->id, json_encode($extra));
        }
        return response()->json($extra);
    }
}
