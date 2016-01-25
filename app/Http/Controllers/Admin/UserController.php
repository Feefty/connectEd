<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests\PostAddUserFormRequest;
use App\Http\Requests\PostEditAccountUserFormRequest;
use App\Http\Requests\PostEditProfileUserFormRequest;
use App\Http\Controllers\Controller;
use App\Group;
use App\User;
use App\Profile;
use Gate;

class UserController extends Controller
{
    public function getAPI()
    {
        if (Gate::denies('api-user'))
        {
            abort(401);
        }

        return User::select('users.*', 'groups.name as group', \DB::raw('(IF(users.status=1,"Active","Inactive")) as status'))
                    ->leftJoin('groups', 'groups.id', '=', 'group_id')
                    ->get();
    }

    public function getIndex()
    {
        if (Gate::denies('read-user'))
        {
            abort(401);
        }

        $groups = Group::orderBy('name')->orderBy('level')->get();
        return view('admin.user.index', compact('groups'));
    }

    public function postAdd(PostAddUserFormRequest $request)
    {
        $msg = [];

        try
        {
            $data = $request->only('username', 'email');
            $data['password'] = bcrypt($request->password);
            $data['group_id'] = $request->group;
            $data['status'] = config('auth.status');
            $data['created_at'] = new \DateTime;
            $user = User::create($data);
            $data = $request->only('first_name', 'middle_name', 'last_name', 'gender',
                                    'address', 'birthday');
            $data['user_id'] = $user->id;
            Profile::create($data);

            $msg = trans('user.add.success');
        }
        catch (\Exception $e)
        {
            return redirect()->back()->withErrors($msg);
        }

        return redirect()->back()->with(compact('msg'));
    }

    public function getView($id)
    {
        if (Gate::denies('read-user'))
        {
            return abort(401);
        }

        $user = User::select('users.*', 'groups.name as group', 'profiles.*',
                        \DB::raw('CONCAT(
                            profiles.first_name,
                            IF(profiles.middle_name <> "",CONCAT(" ",profiles.middle_name," ")," "),
                            profiles.last_name
                        ) as name'))
                    ->leftJoin('profiles', 'profiles.user_id', '=', 'users.id')
                    ->leftJoin('groups', 'groups.id', '=', 'users.group_id')
                    ->findOrFail($id);
        return view('admin.user.view', compact('user'));
    }

    public function getEdit($id)
    {
        if (Gate::denies('update-user'))
        {
            return abort(401);
        }

        $user = User::with('profile', 'group')->findOrFail($id);
        $groups = Group::orderBy('name')->orderBy('level')->get();
        return view('admin.user.edit', compact('user', 'groups'));
    }

    public function postEditAccount(PostEditAccountUserFormRequest $request)
    {
        $msg = [];

        try
        {
            $data = $request->only('username', 'email', 'status');
            $data['group_id'] = $request->group;
            $data['updated_at'] = new \DateTime;

            if ($request->has('npassword'))
            {
                $data['password'] = bcrypt($request->npassword);
            }
            $id = (int) $request->user_id;
            User::where('id', $id)->update($data);

            $msg = trans('user.update.account.success');
        }
        catch (\Exception $e)
        {
            return redirect()->back()->withErrors($msg);
        }

        return redirect()->back()->with(compact('msg'));
    }

    public function postEditProfile(PostEditProfileUserFormRequest $request)
    {
        $msg = [];

        try
        {
            $data = $request->only('first_name', 'middle_name', 'last_name', 'gender',
                                    'address', 'birthday');
            $data['updated_at'] = new \DateTime;
            $id = (int) $request->user_id;

            if (Profile::where('user_id', $id)->exists())
            {
                Profile::where('user_id', $id)->update($data);
            }
            else
            {
                $data['user_id'] = $id;
                Profile::create($data);
            }

            $msg = trans('user.update.profile.success');
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
            if (Gate::denies('delete-user'))
            {
                throw new \Exception(trans('error.unauthorized.action'));
            }

            $user = User::where('id', $id);

            if ($user->exists())
            {
                User::where('id', $id)->delete();
                Profile::where('user_id', $id)->delete();
                $msg = trans('user.delete.success');
            }
            else
            {
                throw new \Exception(trans('user.not_found'));
            }

        }
        catch (\Exception $e)
        {
            return redirect()->back()->withErrors($msg);
        }

        return redirect()->back()->with(compact('msg'));
    }
}
