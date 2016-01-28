<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\GradeSummary;

class GradeSummaryController extends Controller
{
    public function getApi(Request $request)
    {
        $grade_summary = GradeSummary::with('student', 'class_subject');

        if ($request->has('class_subject_id'))
        {
            $grade_summary = $grade_summary->where('class_subject_id', (int) $request->class_subject_id);
        }

        return $grade_summary->orderBy('created_at', 'desc')->get();
    }

    public function postAdd()
    {
        
    }
}
