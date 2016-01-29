<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests\PostAddAchievementFormRequest;
use App\Http\Requests\PostEditAchievementFormRequest;
use App\Http\Controllers\Controller;
use App\Achievement;
use Gate;
use Image;

class AchievementController extends Controller
{
	public function getAPI()
	{
        if (Gate::denies('api-achievement'))
        {
            return abort(401);
        }

		return Achievement::get();
	}

    public function getIndex()
    {
        if (Gate::denies('read-achievement'))
        {
            return abort(401);
        }

    	return view('admin.achievement.index');
    }

    public function postAdd(PostAddAchievementFormRequest $request)
    {
        $msg = [];

        try
        {
            $data = $request->only('title', 'description');
			$icon = $request->file('icon');

			if ($icon->isValid())
			{
				$name = time() .'_'. str_random(15) .'.'. $icon->getClientOriginalExtension();
				$path = public_path() . config('achievement.icon.path') . $name;
				Image::make($icon)->fit(200)->save($path);
				$data['icon'] = $name;
			}
			else
			{
				throw new \Exception('Invalid file icon.');
			}

            Achievement::create($data);

            $msg = trans('achievement.add.success');
        }
        catch (\Exception $e)
        {
            return redirect()->back()->withErrors($e->getMessage());
        }

        return redirect()->back()->with(compact('msg'));
    }

    public function getView($id)
    {
        if (Gate::denies('read-achievement'))
        {
            return abort(401);
        }

    	$achievement = Achievement::findOrFail($id);
    	return view('admin.achievement.view', compact('achievement'));
    }

    public function getEdit($id)
    {
        if (Gate::denies('update-achievement'))
        {
            return abort(401);
        }

    	$achievement = Achievement::findOrFail($id);
    	return view('admin.achievement.edit', compact('achievement'));
    }

    public function postEdit(PostEditAchievementFormRequest $request)
    {
        $msg = [];

        try
        {
            $data = $request->only('title', 'description');
            $id = (int) $request->achievement_id;

			if ($request->hasFile('icon'))
			{
				$icon = $request->file('icon');

				if ($icon->isValid())
				{
					$name = time() .'_'. str_random(15) .'.'. $icon->getClientOriginalExtension();
					$path = public_path() . config('achievement.icon.path') . $name;
					Image::make($icon)->fit(200)->save($path);
					$data['icon'] = $name;

					$old_icon = Achievement::findOrFail($id)->icon;

					if ($old_icon)
					{
						if (file_exists($file_name = public_path() . config('achievement.icon.path'). $old_icon))
	                    {
	                        unlink($file_name);
	                    }
					}
				}
				else
				{
					throw new \Exception('Invalid file icon.');
				}
			}

            Achievement::findOrFail($id)->update($data);

            $msg = trans('achievement.edit.success');
        }
        catch (\Exception $e)
        {
            return redirect()->back()->withErrors($msg);
        }

        return redirect()->back()->with(compact('msg'));
    }

    public function getDelete($id)
    {
        $msg = [];

        try
        {
            if (Gate::denies('delete-achievement'))
            {
                throw new \Exception(trans('error.unauthorized.action'));
            }

        	if (Achievement::where('id', $id)->exists())
        	{
        		Achievement::where('id', $id)->delete();
        	}
        	else
        	{
        		throw new \Exception(trans('achievement.not_found'));
        	}

            $msg = trans('achievement.delete.success');
        }
        catch (\Exception $e)
        {
            return redirect()->back()->withErrors($msg);
        }

        return redirect()->back()->with(compact('msg'));
    }
}
