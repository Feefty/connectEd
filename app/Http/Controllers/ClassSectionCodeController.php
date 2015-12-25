<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\PostGenerateClassCodeFormRequest;
use App\Http\Controllers\Controller;
use App\ClassSection;
use App\ClassSectionCode;
use Hashids;

class ClassSectionCodeController extends Controller
{
	public function getApi(Request $request)
	{
    	$class_section_code = new ClassSectionCode;

    	if ($request->has('section_id'))
    	{
    		$class_section_code = $class_section_code->where('class_section_codes.class_section_id', (int) $request->section_id);
    	}

    	return $class_section_code->orderBy('class_section_codes.created_at', 'desc')->get();
	}

    public function postGenerate(PostGenerateClassCodeFormRequest $request)
    {
        $msg = [];

        try
        {
            $data = [];
            $amount = (int) $request->amount;
            $class_section_id = (int) $request->class_section_id;

            if (ClassSectionCode::where('class_section_id', $class_section_id)->count() >= config('class_section.max_code'))
            {
                throw new \Exception(trans('class_section_code.max_code_reached'));
            }

            for ($i = 0; $i < $amount; $i++)
            {
                $count = ClassSectionCode::count();

                $hash = Hashids::connection('class-code')->encode($count);
                $data = [
                    'code'          => $hash,
                    'created_at'    => new \DateTime,
                    'class_section_id'     => $class_section_id,
                    'status'        => false,
                ];

                ClassSectionCode::create($data);
            }

            $msg = trans('class_section_code.add.success');
        }
        catch (\Exception $e)
        {
            return redirect()->back()->withErrors($e->getMessage());
        }

        return redirect()->back()->with(compact('msg'));
    }
}
