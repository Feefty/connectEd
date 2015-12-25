<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\SchoolCode;

class SchoolCodeController extends Controller
{
    public function getApi(Request $request)
    {
    	$school_code = SchoolCode::select('school_codes.*', 'groups.name as membership')
                                ->leftJoin('groups', 'groups.id', '=', 'school_codes.group_id');

    	if ($request->has('school_id'))
    	{
    		$school_code = $school_code->where('school_codes.school_id', (int) $request->school_id);
    	}

    	return $school_code->orderBy('school_codes.created_at', 'desc')->get();
    }

    public function getDelete($id)
    {
        $msg = [];

        try
        {
            SchoolCode::findOrFail($id)->delete();
            
            $msg = trans('school_code.delete.success');
        }
        catch (\Exception $e)
        {
            return redirect()->back()->withErrors($e->getMessage());
        }

        return redirect()->back()->with(compact('msg'));
    }
}
