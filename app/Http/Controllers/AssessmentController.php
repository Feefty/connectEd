<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\PostAddAssessmentFormRequest;
use App\Http\Controllers\Controller;
use App\Assessment;
use App\Subject;
use App\Profile;
use App\User;
use App\AssessmentCategory;

class AssessmentController extends Controller
{
    public function getData(Request $request)
    {
        $data = [];

        if ($request->has('student_id') && $request->has('subject_id'))
        {
            $student_id = (int) $request->student_id;
            $subject_id = (int) $request->subject_id;
        }
        else
        {
            die(401);
        }

        $assessments = Assessment::whereHas('class_subject', function($query) use($subject_id) {
            $query->where('subject_id', $subject_id);
        })
        ->whereHas('class_student', function($query) use($student_id) {
            $query->where('student_id', $student_id);
        })
        ->groupBy('source')
        ->orderBy('source')
        ->get();

        $data = [];

        $data['datasets'][0] = [
                'fillColor' => 'rgba(96, 179, 255, 0.5)',
                'strokeColor' => 'rgba(16, 127, 190, 0.8)',
                'highlightFill' => 'rgba(66, 163, 224, 0.75)',
                'highlightStroke' => 'rgba(76, 171, 240, 1)'
        ];

        foreach ($assessments as $assessment)
        {
            $data['labels'][] = $assessment->source;

            $score = Assessment::whereHas('class_subject', function($query) use($subject_id) {
                $query->where('subject_id', $subject_id);
            })
            ->whereHas('class_student', function($query) use($student_id) {
                $query->where('student_id', $student_id);
            })
            ->where('source', $assessment->source)
            ->sum('score');

            $total = Assessment::whereHas('class_subject', function($query) use($subject_id) {
                $query->where('subject_id', $subject_id);
            })
            ->whereHas('class_student', function($query) use($student_id) {
                $query->where('student_id', $student_id);
            })
            ->where('source', $assessment->source)
            ->sum('total');

            $data['datasets'][0]['data'][] = round(($score / $total) * 100);
        }

        return $data;
    }

    public function getApi(Request $request)
    {
        $assessment = Assessment::with('class_student.student.profile',
                                        'class_student.student.school_member.school',
                                        'class_subject_exam.class_subject.subject',
                                        'class_subject.subject');

        if ($request->has('class_subject_id'))
        {
            $assessment = $assessment->where('class_subject_id', (int) $request->class_subject_id);
        }

        if ($request->has('source'))
        {
            $assessment = $assessment->where('source', rawurldecode($request->source));
        }

        switch (strtolower(auth()->user()->group->name))
        {
            case 'student':
                $assessment = $assessment->whereHas('class_student', function($query) {
                    $query->where('student_id', auth()->user()->id);
                });
                break;
            case 'teacher':
                $assessment = $assessment->whereHas('class_subject', function($query) {
                    $query->where('teacher_id', auth()->user()->id);
                });
                break;
            case 'school':
                $assessment = $assessment->where(function($query) {
                    $query->whereHas('class_subject.class_section', function($query) {
                        $query->where('school_id', auth()->user()->school_member->school_id);
                    })->orWhereHas('class_subject_exam.class_subject.class_section', function($query) {
                        $query->where('school_id', auth()->user()->school_member->school_id);
                    });
                });
                break;
        }

        return $assessment->orderBy('created_at', 'desc')->get();
    }

    public function getIndex()
    {
        $students = Profile::with('user.class_student.class_section')
        ->whereHas('user.school_member', function($query) {
            $query->where('school_id', auth()->user()->school_member->school_id);
        })->whereHas('user.group', function($query) {
            $query->where('name', 'Student');
        })->orderBy('last_name')->orderBy('first_name')->get();

        $subjects = Subject::orderBy('name')->orderBy('code')->get();
        $assessment_categories = AssessmentCategory::orderby('name')->get();
        return view('assessment.index', compact('subjects', 'students', 'assessment_categories'));
    }

    public function postAdd(PostAddAssessmentFormRequest $request)
    {
        $msg = [];

        try
        {
            foreach ($request->students as $student)
            {
                $data = $request->only('assessment_category_id', 'score', 'total', 'source', 'quarter', 'recorded', 'class_subject_id', 'date');
                $user = User::with('class_student')->find((int) $student);
                $data['class_student_id'] = (int) $user->class_student->id;
                $data['created_at'] = new \DateTime;

                if ($request->has('other'))
                {
                    $data['source'] = $request->other;
                }

                if ((int) $data['score'] > (int) $data['total'])
                {
                    throw new \Exception(trans('assessment.invalid_grade'));
                }
            }

            Assessment::insert($data);

            $msg = trans('assessment.add.success');
        }
        catch (\Exception $e)
        {
            return ['error' => $e->getMessage()];
        }

        return ['status' => 'success', 'msg' => $msg];
    }

    public function getDelete($id)
    {
        $msg = [];

        try
        {
            Assessment::findOrFail($id)
                        ->delete();

            $msg = trans('assessment.delete.success');
        }
        catch (\Exception $e)
        {
            return redirect()->back()->withErrors($e->getMessage());
        }

        return redirect()->back()->with(compact('msg'));
    }
}
