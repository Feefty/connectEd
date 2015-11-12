<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests\PostAddGroupFormRequest;
use App\Http\Requests\PostEditGroupFormRequest;
use App\Http\Controllers\Controller;
use App\Group;
use Gate;

class GroupController extends Controller
{
	public function getAPI()
	{
        if (Gate::denies('api-group'))
        {
            return abort(401);
        }

		return Group::get();
	}

    public function getIndex()
    {
        if (Gate::denies('read-group'))
        {
            return abort(401);
        }

        return view('admin.group.index');
    }

    public function postAdd(PostAddGroupFormRequest $request)
    {
        $msg = [];

        try
        {
            $data = $request->only('name', 'level', 'description');
            Group::create($data);
            
            $msg = trans('group.add.success');
        }
        catch (\Exception $e)
        {
            return redirect()->back()->withErrors($msg);
        }

        return redirect()->back()->with(compact('msg'));
    }

    public function getView($id)
    {
        if (Gate::denies('read-group'))
        {
            return abort(401);
        }

    	$group = Group::findOrFail($id);

    	return view('admin.group.view', compact('group'));
    }

    public function getEdit($id)
    {
        if (Gate::denies('update-group'))
        {
            return abort(401);
        }

    	$group = Group::findOrFail($id);

 		return view('admin.group.edit', compact('group'));
    }

    public function postEdit(PostEditGroupFormRequest $request)
    {
        $msg = [];

        try
        {
            $data = $request->only('name', 'level', 'description');
            $id = (int) $request->group_id;
            Group::where('id', $id)->update($data);
            
            $msg = trans('group.update.success');
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
            if (Gate::denies('delete-group'))
            {
                throw new \Exception(trans('error.unauthorized.action'));
            }

            $group = Group::where('id', $id);

            if ($group->exists())
            {
                Group::where('id', $id)->delete();
                $msg = trans('group.delete.success');
            }
            else
            {
                throw new \Exception(trans('group.not_found'));
            }

        }
        catch (\Exception $e)
        {
            return redirect()->back()->withErrors($msg);
        }

        return redirect()->back()->with(compact('msg'));
    }
}
