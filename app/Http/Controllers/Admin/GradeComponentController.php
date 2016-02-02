<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests\PostAddGradeComponentFormRequest;
use App\Http\Requests\PostAddSubjectGradeComponentFormRequest;
use App\Http\Controllers\Controller;
use App\GradeComponent;

class GradeComponentController extends Controller
{
    public function getData(Request $request)
    {
        $data = [];
        $grade_component = GradeComponent::with('assessment_category');

        if ($request->has('subject_id'))
        {
            $grade_component = $grade_component->where('subject_id', (int) $request->subject_id);
        }

        if ($request->has('level'))
        {
            $grade_component = $grade_component->where('level', (int) $request->level);
        }

        foreach ($grade_component->get() as $row)
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
            $data = [];

            foreach ($request->level as $level)
            {

                $tmp_data = $request->only('description', 'subject_id', 'percentage', 'assessment_category_id', 'color');
                $percentage = GradeComponent::where('subject_id', $tmp_data['subject_id'])->where('level', $tmp_data['level'])->sum('percentage');

                if ($percentage >= 100 ||
                    ($percentage + $tmp_data['percentage']) > 100)
                {
                    throw new \Exception(trans('grade_component.percentage.error'));
                }

                $data[] = [
                    'description' => $request->description,
                    'subject_id' => $request->subject_id,
                    'percentage' => $request->percentage,
                    'assessment_category_id' => $request->assessment_category_id,
                    'color' => $request->color,
                    'level' => $level
                ];
            }

            GradeComponent::insert($data);

            $msg = trans('grade_component.add.success');
        }
        catch (\Exception $e)
        {
            return redirect()->back()->withErrors($e->getMessage());
        }

        return redirect()->back()->with(compact('msg'));
    }

    public function getEdit($id)
    {
        $grade_component = GradeComponent::findOrFail($id);
        return view('admin.subject.grade.edit', compact('grade_component'));
    }

    public function postEdit(PostAddSubjectGradeComponentFormRequest $request)
    {
        $msg = [];

        try
        {
            $data = $request->only('color', 'percentage', 'level');
            $percentage = GradeComponent::where('subject_id', $request->subject_id)->where('level', $data['level'])->where('id', '<>', (int) $request->grade_component_id)->sum('percentage');

            if ($percentage >= 100 ||
                ($percentage + $data['percentage']) > 100)
            {
                throw new \Exception(trans('grade_component.percentage.error'));
            }

            GradeComponent::findOrFail((int) $request->grade_component_id)->update($data);

            $msg = trans('grade_component.edit.success');
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
            GradeComponent::findOrFail((int) $id);
            $msg = trans('grade_component.delete.success');
        }
        catch (\Exception $e)
        {
            return redirect()->back()->withErrors($e->getMessage());
        }

        return redirect()->back()->with(compact('msg'));
    }
}
