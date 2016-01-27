<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\PostSaveSettingsProfileFormRequest;
use App\Http\Requests\PostSaveSettingsPasswordFormRequest;
use App\Http\Requests\PostSaveSettingsEmailFormRequest;
use App\Http\Requests\PostAddPhotoFormRequest;
use App\Http\Requests\PostSaveSettingsParentCodeFormRequest;
use App\Http\Controllers\Controller;
use App\Profile;
use App\User;
use Hash;
use Gate;
use Image;

class SettingsController extends Controller
{
    public function getProfile()
    {
        if (Gate::denies('profile-settings'))
        {
            abort(401);
        }

        $profile = Profile::where('user_id', auth()->user()->id)->first();

    	return view('settings.profile', compact('profile'));
    }

    public function postProfile(PostSaveSettingsProfileFormRequest $request)
    {
    	$msg = [];

    	try
    	{
    		$data = $request->only('first_name', 'last_name', 'middle_name', 'birthday', 'address', 'gender');

            Profile::where('user_id', auth()->user()->id)
                    ->update($data);

    		$msg = trans('settings.update.success');
    	}
    	catch (\Exception $e)
    	{
            return redirect()->back()->withErrors($e->getMessage());
    	}

    	return redirect()->back()->with(compact('msg'));
    }

    public function getPhoto()
    {
        $profile = auth()->user()->profile;
        return view('settings.photo', compact('profile'));
    }

    public function postPhoto(PostAddPhotoFormRequest $request)
    {
        $msg = [];

        try
        {
            $photo = $request->file('photo');

            if ($photo->isValid())
            {
                $name = time() .'_'. str_random(15) .'.'. $photo->getClientOriginalExtension();
                $path = public_path() . config('profile.photo.path') . $name;
                Image::make($photo)->fit(200, 250)->save($path);

                $user = $request->user()->profile;

                if ( ! empty($user->photo) && ! is_null($user->photo))
                {
                    if (file_exists($file_name = public_path() . config('profile.photo.path') . $user->photo))
                    {
                        unlink($file_name);
                    }
                }

                $user->photo = $name;
                $user->save();

                $msg = trans('settings.update.success');
            }
            else
            {
                throw new \Exception(trans('settings.photo.failed'));
            }
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
    public function getParentCode()
    {
        $parent_code = auth()->user()->profile->parent_code;
        return view('settings.parent_code', compact('parent_code'));
    }

    public function postParentCode(PostSaveSettingsParentCodeFormRequest $request)
    {
    	$msg = [];

    	try
    	{
    		$parent_code = auth()->user()->id . str_random(10);
            Profile::where('user_id', auth()->user()->id)->update(['parent_code' => $parent_code]);

    		$msg = trans('settings.parent_code.success');
    	}
    	catch (\Exception $e)
    	{
    		return redirect()->back()->withErrors($e->getMessage());
    	}

    	return redirect()->back()->with(compact('msg'));
    }
}
