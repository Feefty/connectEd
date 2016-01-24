<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\VerificationCode;

class VerificationCodeController extends Controller
{
    public function getApi(Request $request)
    {
    	$verification_code = VerificationCode::with('group');

    	if ($request->has('school_id'))
    	{
    		$verification_code = $verification_code->where('school_id', (int) $request->school_id);
    	}

    	return $verification_code->orderBy('created_at', 'desc')->get();
    }

    public function getDelete($id)
    {
        $msg = [];

        try
        {
            VerificationCode::findOrFail($id)->delete();
            
            $msg = trans('verification_code.delete.success');
        }
        catch (\Exception $e)
        {
            return redirect()->back()->withErrors($e->getMessage());
        }

        return redirect()->back()->with(compact('msg'));
    }
}
