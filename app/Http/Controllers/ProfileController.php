<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\User;
use App\GradeSummary;
use App\Subject;

class ProfileController extends Controller
{
    public function getIndex(Request $request)
    {
        $user = auth()->user();

        if (strtolower(auth()->user()->group->name) == 'student')
        {
            $school_years = GradeSummary::where('student_id', $user->id)->groupBy('school_year')->get();
            $grades = GradeSummary::where('student_id', $user->id)->get();
            $subjects = Subject::whereHas('class_subject.class_section', function($query) use($user) {
                $query->where('id', $user->class_student->class_section->id);
            })->orderBy('name')->get();
        }

        return view('profile.index', compact('user', 'school_years', 'grades', 'subjects'));
    }

    public function getUser($username)
    {
        $user = User::with('profile', 'school_member.school', 'group')->where('username', $username);

        if ($user->exists())
        {
            $user = $user->first();
        }
        else
        {
            return abort(404);
        }

        if (strtolower($user->group->name) == 'student')
        {
            $school_years = GradeSummary::where('student_id', $user->id)->groupBy('school_year')->get();
            $grades = GradeSummary::where('student_id', $user->id)->get();

            $subjects = Subject::whereHas('class_subject.class_section', function($query) use($user) {
                $query->where('id', $user->class_student->class_section->id);
            })->orderBy('name')->get();
        }

        return view('profile.index', compact('user', 'school_years', 'grades', 'subjects'));
    }
}
