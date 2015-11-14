<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\PostSaveSettingsProfileFormRequest;
use App\Http\Requests\PostSaveSettingsPasswordFormRequest;
use App\Http\Requests\PostSaveSettingsEmailFormRequest;
use App\Http\Controllers\Controller;
use App\Profile;
use App\User;
use Hash;
use Gate;

class SettingsController extends Controller
{
    public function getProfile(Request $request)
    {
        if (Gate::denies('profile-settings'))
        {
            abort(401);
        }

    	$profile = Profile::where('user_id', $request->user()->id)->first();
    	return view('settings.profile', compact('profile'));
    }

    public function postProfile(PostSaveSettingsProfileFormRequest $request)
    {
    	$msg = [];
        
    	try
    	{
    		$data = $request->only('first_name', 'last_name', 'middle_name', 'birthday', 'address', 'gender');

    		$user = $request->user();
    		$profile = Profile::where('user_id', $user->id);
    		$data['updated_at'] = new \DateTime;

    		if ($profile->exists())
    		{
    			Profile::where('user_id', $user->id)->update($data);
    		}
    		else
    		{
    			$data['user_id'] = $user->id;
    			Profile::create($data);
    		}

    		$msg = trans('settings.update.success');
    	}
    	catch (\Exception $e)
    	{
            return redirect()->back()->withErrors($e->getMessage());
    	}

    	return redirect()->back()->with(compact('msg'));
    }
    public function getPassword()
    {
        if (Gate::denies('password-settings'))
        {
            abort(401);
        }

    	return view('settings.password');
    }

    public function postPassword(PostSaveSettingsPasswordFormRequest $request)
    {
    	$msg = [];

    	try
    	{
    		$user = $request->user();
    		$old_password = $user->password;

    		if (Hash::check($request->cpassword, $old_password))
    		{
	    		$user->password = bcrypt($request->npassword);
	    		$user->save();

	    		$msg = trans('settings.update.success');
    		}
    		else
    		{
    			throw new \Exception(trans('settings.current_password.fail'));
    		}
    	}
    	catch (\Exception $e)
    	{
    		return redirect()->back()->withErrors($e->getMessage());
    	}

    	return redirect()->back()->with(compact('msg'));
    }
    public function getEmail(Request $request)
    {
        if (Gate::denies('email-settings'))
        {
            abort(401);
        }

    	$email = $request->user()->email;
    	return view('settings.email', compact('email'));
    }

    public function postEmail(PostSaveSettingsEmailFormRequest $request)
    {
    	$msg = [];

    	try
    	{
    		$user = $request->user();
    		$old_password = $user->password;
            
    		if (Hash::check($request->cpassword, $old_password))
    		{
	    		$user->email = $request->email;
	    		$user->save();

	    		$msg = trans('settings.update.success');
    		}
    		else
    		{
    			throw new \Exception(trans('settings.current_password.fail'));
    		}
    	}
    	catch (\Exception $e)
    	{
    		return redirect()->back()->withErrors($e->getMessage());
    	}

    	return redirect()->back()->with(compact('msg'));
    }
    public function getPrivacy()
    {
        if (Gate::denies('privacy-settings'))
        {
            abort(401);
        }

    	return view('settings.privacy');
    }

    public function postPrivacy(PostSaveSettingsProfileFormRequest $request)
    {

    }
}
