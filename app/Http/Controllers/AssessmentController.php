<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\PostAddAssessmentFormRequest;
use App\Http\Controllers\Controller;
use App\Assessment;
use App\Subject;
use App\Profile;
use App\User;

class AssessmentController extends Controller
{
    public function getData()
    {
        $data = [];
        
        $labels = Subject::whereHas('class_subject.class_section.student', function($query) {
            $query->where('student_id', auth()->user()->id);
        })->orderBy('name')->get();

        $data_label = [];
        $data_subject = [];

        foreach ($labels as $label)
        {
            $data_label[] = $label->name;


            $assessment = Assessment::whereHas('class_student.student', function($query) {
                $query->where('id', auth()->user()->id);
            })
            ->whereHas('class_subject.subject', function($query) use($label) {
                $query->where('id', $label->id);
            })
            ->where('recorded', 1)
            ->get();
            $score = (double) $assessment->sum('score');
            $total = (double) $assessment->sum('total');

            if ($total == 0)
            {
                $data_subject[] = 0;
            }
            else
            {
                $data_subject[] = floor(($score/$total)*100);
            }
        }

        $data = [
            'labels' => $data_label,
            'datasets' => [
                [
                'label' => "My Performance",
                'fillColor' => "rgba(220,220,220,0.2)",
                'strokeColor' => "rgba(220,220,220,1)",
                'pointColor' => "rgba(220,220,220,1)",
                'pointStrokeColor' => "#fff",
                'pointHighlightFill' => "#fff",
                'pointHighlightStroke' => "rgba(220,220,220,1)",
                'data' => $data_subject
                ]
            ]
        ];

        return $data;
    }

    public function getApi(Request $request)
    {
        $assessment = Assessment::with('class_student.student.profile', 'class_student.student.school_member.school', 'class_subject_exam.subject', 'class_subject.subject');

        if ($request->has('class_subject_id'))
        {
            $assessment = $assessment->where('class_subject_id', (int) $request->class_subject_id);
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
                $assessment = $assessment->whereHas('class_subject.class_section', function($query) {
                    $query->where('school_id', auth()->user()->school_member->school_id);
                });
                break;
        }

        return $assessment->orderBy('created_at')->get();
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
        return view('assessment.index', compact('subjects', 'students'));
    }

    public function postAdd(PostAddAssessmentFormRequest $request)
    {
        $msg = [];

        try
        {
            foreach ($request->students as $student)
            {
                $data = $request->only('score', 'total', 'source', 'term', 'recorded', 'class_subject_id', 'date');
                $user = User::with('class_student')->find((int) $student);
                $data['class_student_id'] = (int) $user->class_student->id;
                $data['created_at'] = new \DateTime;

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
            return redirect()->back()->withErrors($msg);
        }

        return redirect()->back()->with(compact('msg'));
    }
}
