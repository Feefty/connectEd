<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class AssessmentController extends Controller
{
    public function getApi(Request $request)
    {
        $assessment = Assessment::with('assessment_type');

        if ($request->has('school_id'))
        {
            $assessment = $assessment->where('school_id', (int) $request->school_id);
        }

        return $assessment->orderBy('created_at', 'desc')->get();
    }

    public function getIndex()
    {
        return view('admin.assessment.index');
    }
}
