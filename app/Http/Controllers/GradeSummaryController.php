<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\PostAddGradeSummaryFormRequest;
use App\Http\Controllers\Controller;
use App\GradeSummary;
use App\Assessment;
use App\AssessmentCategory;
use App\GradeComponent;
use App\ClassSubject;

class GradeSummaryController extends Controller
{
    public function getData(Request $request)
    {
        $grade_summary = new GradeSummary;

        if ($request->has('student_id'))
        {
            $grade_summary = $grade_summary->where('student_id', (int) $request->student_id);
        }

        if ($request->has('school_year'))
        {
            $grade_summary = $grade_summary->where('school_year', (int) $request->school_year);
        }
        else
        {
            abort(404);
        }

        $data = [];
        $data['datasets'][0] = [
            'fillColor' => 'rgba(220,220,220,0.5)',
            'strokeColor' => 'rgba(220,220,220,0.8)',
            'highlightFill' => 'rgba(220,220,220,0.75)',
            'highlightStroke' => 'rgba(220,220,220,1)'
        ];
        $average = 0;

        for ($quarter = 1; $quarter <= 4; $quarter++)
        {
            foreach ($grade_summary->orderBy('quarter')->get() as $row)
            {
                if ($quarter == $row->quarter)
                {
                    $data['labels'][] = 'Quarter '. $quarter;
                    $data['datasets'][0]['data'][] = round($row->grade);
                    $average += $row->grade;
                    break;
                }
            }
        }

        $data['labels'][] = 'Final';
        $data['datasets'][0]['data'][] = round($average/4);

        return $data;
    }

    public function getApi(Request $request)
    {
        $grade_summary = GradeSummary::with('student.profile', 'class_subject');

        if ($request->has('class_subject_id'))
        {
            $grade_summary = $grade_summary->where('class_subject_id', (int) $request->class_subject_id);
        }

        if ($request->has('quarter'))
        {
            $grade_summary = $grade_summary->where('quarter', (int) $request->quarter);
        }

        return $grade_summary->orderBy('created_at', 'desc')->get();
    }

    public function postAdd(PostAddGradeSummaryFormRequest $request)
    {
        $msg = [];

        try
        {
            $data = $request->only('student_id', 'quarter', 'school_year', 'class_subject_id');
            $grade = 0;
            $grade_data = [];

            $subject_id = ClassSubject::findOrfail($data['class_subject_id'])->subject_id;

            foreach (AssessmentCategory::get() as $assessment_category)
            {
                foreach (GradeComponent::where('assessment_category_id', $assessment_category->id)->where('subject_id', $subject_id)->get() as $grade_component)
                {
                    $score = Assessment::whereHas('class_subject', function($query) use($data) {
                                            $query->where('id', $data['class_subject_id']);
                                        })
                                        ->orWhereHas('class_subject_exam.class_subject', function($query) use($data) {
                                            $query->where('id', $data['class_subject_id']);
                                        })
                                        ->whereHas('class_student.student', function($query) use($data) {
                                            $query->where('id', $data['student_id']);
                                        })
                                        ->whereHas('class_student.class_section', function($query) use($data, $grade_component) {
                                            $query->where('year', $data['school_year'])
                                                    ->where('level', $grade_component->level);
                                        })
                                        ->where('quarter', $data['quarter'])
                                        ->where('assessment_category_id', $assessment_category->id)
                                        ->sum('score');
                    $total = Assessment::whereHas('class_subject', function($query) use($data) {
                                            $query->where('id', $data['class_subject_id']);
                                        })
                                        ->orWhereHas('class_subject_exam.class_subject', function($query) use($data) {
                                            $query->where('id', $data['class_subject_id']);
                                        })
                                        ->whereHas('class_student.student', function($query) use($data) {
                                            $query->where('id', $data['student_id']);
                                        })
                                        ->whereHas('class_student.class_section', function($query) use($data, $grade_component) {
                                            $query->where('year', $data['school_year'])
                                                    ->where('level', $grade_component->level);
                                        })
                                        ->where('quarter', $data['quarter'])
                                        ->where('assessment_category_id', $assessment_category->id)
                                        ->sum('total');
                    //dd($grade_component->percentage);
                    $assessment_category_grade = ($score/$total) * 100;
                    $grade += ($assessment_category_grade / 100) * $grade_component->percentage;
                    $grade_data[] = [
                        $assessment_category_grade,
                        $grade
                    ];
                }
            }
            dd($grade_data);
            $data['grade'] = round($grade);

            if ($grade < 75)
            {
                $data['remarks'] = 0;
            }
            else
            {
                $data['remarks'] = 1;
            }

            $grade_summary = GradeSummary::where($request->only('student_id', 'quarter', 'school_year', 'class_subject_id'));
            if ($grade_summary->exists())
            {
                $grade_summary->update($data);
            }
            else
            {
                GradeSummary::create($data);
            }

            $msg = trans('grade_summary.submit.success');
        }
        catch (\Exception $e)
        {
            return redirect()->back()->withErrors($e->getMessage());
        }

        return redirect()->back()->with(compact('msg'));
    }
}
