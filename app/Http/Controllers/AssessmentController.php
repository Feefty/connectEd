<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\PostAddAssessmentFormRequest;
use App\Http\Controllers\Controller;
use App\Assessment;
use App\Subject;
use App\Profile;

class AssessmentController extends Controller
{
    public function getApi(Request $request)
    {
        $assessment = Assessment::with('student.profile', 'assessed.profile', 'class_subject_exam', 'school', 'subject');

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
        $students = Profile::whereHas('user.school_member', function($query) {
            $query->where('school_id', auth()->user()->school_member->school_id);
        })->whereHas('user.group', function($query) {
            $query->where('name', 'LIKE', '%Student%');
        })->orderBy('last_name')->orderBy('first_name')->get();

        $subjects = Subject::orderBy('name')->orderBy('code')->get();
        return view('assessment.index', compact('subjects', 'students'));
    }

    public function postAdd(PostAddAssessmentFormRequest $request)
    {
        $msg = [];

        try
        {
            $data = $request->only('score', 'total', 'source', 'term');
            $data['subject_id'] = (int) $request->subject;
            $data['student_id'] = (int) $request->student;
            $data['school_id'] = auth()->user()->school_member->school_id;
            $data['assessed_by'] = auth()->user()->id;

            if ($data['score'] > $data['total'])
            {
                throw new \Exception(trans('assessment.invalid_grade'));
            }

            Assessment::create($data);
            
            $msg = trans('assessment.add.success');
        }
        catch (\Exception $e)
        {
            return redirect()->back()->withErrors($msg);
        }

        return redirect()->back()->with(compact('msg'));
    }
}
