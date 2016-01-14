<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\PostAddClassSubjectExamFormRequest;
use App\Http\Controllers\Controller;
use App\ClassSubjectExamUser;
use App\ClassSubjectExam;
use App\User;
use App\ExamQuestion;
use App\ExamQuestionAnswer;
use App\StudentExamQuestionAnswer;
use App\Assessment;
use App\Profile;
use App\ClassStudent;

class ClassSubjectExamController extends Controller
{
    public function getApi(Request $request)
    {
        $class_subject_exam = ClassSubjectExam::with('exam.exam_type');

        if ($request->has('class_subject_id'))
        {
            $class_subject_exam = $class_subject_exam->where('class_subject_id', (int) $request->class_subject_id);
        }

        return $class_subject_exam->with('exam')->orderBy('created_at', 'desc')->get();
    }

    public function getView($id)
    {
        $id = (int) $id;
        $class_subject_exam = ClassSubjectExam::findOrFail($id);
        $users = Profile::whereHas('user.class_student.class_section.subject.class_subject_exam', function($query) use($id) {
                        return $query->where('id', $id);
                    })
                    ->whereNotIn('id', function($query) use($id) {
                        $query->select('user_id')
                                ->from('class_subject_exam_users')
                                ->whereRaw('class_subject_exam_users.class_subject_exam_id = '. $id);
                    })
                    ->orderBy('last_name')
                    ->orderBy('first_name')
                    ->get();

        return view('class.exam.view', compact('class_subject_exam', 'users'));
    }

    public function getTake($id)
    {
        $class_subject_exam = ClassSubjectExam::with('exam.subject', 'exam.school')
                                ->whereHas('class_subject_exam_user', function($query) {
                                    $query->where('user_id', auth()->user()->id);
                                })
                                ->findOrFail($id);

        $user_questions_taken_count = auth()
                                ->user()
                                ->student_exam_question_answer()
                                ->whereHas('exam_question.exam', function($query) use($id) {
                                    $query->where('id', (int) $id);
                                })
                                ->groupBy('exam_question_id')
                                ->get()
                                ->count();
        $exam_questions_count = ExamQuestion::where('exam_id', $id)->groupBy('id')->get()->count();
        $grade = null;

        if ($exam_questions_count > $user_questions_taken_count)
        {
            $show_questions = true;
        }
        else
        {
            $show_questions = false;
            $grade = $this->getGrade($id);
        }

        return view('class.exam.take', compact('class_subject_exam', 'show_questions', 'grade'));
    }

    public function getQuestion($id)
    {
        return ExamQuestion::whereHas('exam.class_subject_exam.class_subject_exam_user', function($query) {
                                $query->where('user_id', auth()->user()->id);
                            })
                            ->whereHas('exam.class_subject_exam', function($query) {
                                $query->where('status', 1)
                                    ->where('start', '<=', \DB::raw('NOW()'))
                                    ->where('end', '>=', \DB::raw('NOW()'));
                            })
                            ->has('student_exam_question_answer', '<', 1)
                            ->where('exam_id', (int) $id)
                            ->orderBy(\DB::raw('RAND()'))
                            ->first();
    }

    public function getGrade($exam_id, $student_id = null)
    {
        $data = [];

        if (is_null($student_id))
        {
            $student_id = auth()->user()->id;
        }

        $data['total'] = ExamQuestionAnswer::whereHas('exam_question.exam', function($query) use($exam_id) {
                                            $query->where('id', (int) $exam_id);
                                         })
                                        ->sum('points');
        $data['score'] = StudentExamQuestionAnswer::whereHas('exam_question.exam', function($query) use($exam_id) {
                                                    $query->where('id', (int) $exam_id);
                                                 })
                                                ->where('user_id', $student_id)
                                                ->sum('points');
        return $data;
    }

    public function postAnswer(Request $request)
    {
        $this->validate($request, [
            'answer'            => 'max:255',
            'timer'             => 'integer',
            'exam_question_id'  => 'required|exists:exam_questions,id'
        ]);

        $exam_question_id = (int) $request->exam_question_id;
        $class_subject_id = (int) $request->class_subject_id;
        $class_student_id = (int) $request->class_student_id;

        $student_answer = StudentExamQuestionAnswer::where(['user_id' => $request->user()->id, 'exam_question_id' => $exam_question_id])->exists();

        if ( ! $student_answer)
        {
            // get the points
            $points = (int) ExamQuestionAnswer::where([
                                'exam_question_id'  => $exam_question_id,
                                'answer'            => $request->answer
                            ])->pluck('points');

            StudentExamQuestionAnswer::create([
                'answer'            => $request->answer,
                'user_id'           => (int) $request->user()->id,
                'time_answered'     => (int) $request->timer,
                'exam_question_id'  => $exam_question_id,
                'points'            => $points,
                'created_at'        => new \DateTime
            ]);

            $exam_question = ExamQuestion::with('exam.author')->findOrFail($exam_question_id);

            $user_questions_taken_count = auth()
                                ->user()
                                ->student_exam_question_answer()
                                ->whereHas('exam_question.exam', function($query) use($exam_question) {
                                    $query->where('id', $exam_question->exam_id);
                                })
                                ->groupBy('exam_question_id')
                                ->get()
                                ->count();
            $exam_questions_count = ExamQuestion::where('exam_id', $exam_question->exam_id)
                                                ->groupBy('id')
                                                ->get()
                                                ->count();
                                                        
            if ($exam_questions_count >= $user_questions_taken_count)
            {
                $grade = $this->getGrade($exam_question->exam_id);

                $class_student = ClassStudent::where('student_id', auth()->user()->id)->orderBy('created_at', 'desc')->first();

                $data = [
                    'score'                 => $grade['score'],
                    'total'                 => $grade['total'],
                    'source'                => 'Examination',
                    'recorded'                => 1,
                    'class_student_id'      => $class_student->id,
                    'class_subject_exam_id' => (int) $request->class_subject_exam_id,
                    'class_subject_id'      => (int) $request->class_subject_id,
                ];

                Assessment::create($data);
            }                                   

            return ["status" => "success"];
        }
        else
        {
            return response()->json(['msg' => 'You have already answered this question.'], 422);
        }
    }

    public function getAnswer($question_id)
    {
        $exam_question = ExamQuestion::where('id', $question_id)
                                    ->where(function($query) {
                                        $query->where('category', 'multiplechoice')
                                            ->orWhere('category', 'fillintheblank');
                                    });
        if ( ! $exam_question->exists())
        {
            return abort(404);
        }

        $exam_question = $exam_question->first();
        if ($exam_question->category == 'fillintheblank')
        {
            return ExamQuestionAnswer::where('exam_question_id', $question_id)
                                    ->count();
        }
        else
        {
            return ExamQuestionAnswer::where('exam_question_id', $question_id)
                                    ->get();
        }
    }

    public function postAdd(PostAddClassSubjectExamFormRequest $request)
    {
        $msg = [];

        try
        {
        	$data = $request->only('class_subject_id');
        	$data['start'] = $request->start_date .' '. $request->start_time;
        	$data['end'] = $request->end_date .' '. $request->end_time;
        	$data['exam_id'] = $request->exam;
            $data['created_at'] = new \DateTime;
            $data['status'] = $request->status;

            $class_subject_exam = ClassSubjectExam::create($data);

            $data = [];
            foreach ($request->users as $user)
            {
                $data[] = [
                    'user_id' => $user,
                    'class_subject_exam_id' => $class_subject_exam->id,
                    'created_at' => new \DateTime
                ];
            }

            ClassSubjectExamUser::insert($data);
            
            $msg = trans('class_subject_exam.add.success');
        }
        catch (\Exception $e)
        {
            return redirect()->back()->withErrors($e->getMessage());
        }

        return redirect()->back()->with(compact('msg'));
    }

    public function getDelete($id)
    {
        $msg = [];

        try
        {
            ClassSubjectExam::findOrFail($id)->delete();
            
            $msg = trans('class_subject_exam.delete.success');
        }
        catch (\Exception $e)
        {
            return redirect()->back()->withErrors($e->getMessage());
        }

        return redirect()->back()->with(compact('msg'));
    }
}
