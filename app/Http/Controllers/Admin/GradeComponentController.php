<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests\PostAddGradeComponentFormRequest;
use App\Http\Controllers\Controller;
use App\GradeComponent;

class GradeComponentController extends Controller
{
    public function getData($subject_id)
    {
        $data = [];
        $grade_component = GradeComponent::with('assessment_category')->where('subject_id', (int) $subject_id)->get();

        foreach ($grade_component as $row)
        {
            $data[] = [
                'value'     => $row->percentage,
                'label'     => $row->assessment_category->name,
                'color'     => $row->color
            ];
        }

        return $data;
    }

    public function getApi($subject_id)
    {
        return GradeComponent::with('assessment_category', 'subject')->where('subject_id', (int) $subject_id)->orderBy('created_at', 'desc')->get();
    }

    public function postAdd(PostAddGradeComponentFormRequest $request)
    {
        $msg = [];

        try
        {
            $data = $request->only('description', 'subject_id', 'percentage', 'assessment_category_id', 'color');
            $percentage = GradeComponent::where('subject_id', $data['subject_id'])->sum('percentage');

            if ($percentage >= 100 ||
                ($percentage + $data['percentage']) > 100)
            {
                throw new \Exception(trans('grade_component.percentage.error'));
            }

            GradeComponent::create($data);

            $msg = trans('grade_component.add.success');
        }
        catch (\Exception $e)
        {
            return redirect()->back()->withErrors($e->getMessage());
        }

        return redirect()->back()->with(compact('msg'));
    }
}
