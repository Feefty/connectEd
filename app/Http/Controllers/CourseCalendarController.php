<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\PostAddCourseCalendarFormRequest;
use App\Http\Controllers\Controller;

class CourseCalendarController extends Controller
{
    public function getIndex()
    {
        return view('course_calendar.index');
    }

    public function postAdd(PostAddCourseCalendarFormRequest $request)
    {
        
    }
}
