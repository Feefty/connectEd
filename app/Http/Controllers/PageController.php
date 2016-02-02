<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\PostAddPageFormRequest;
use App\Http\Requests\PostEditPageFormRequest;
use App\Http\Controllers\Controller;
use App\Page;

class PageController extends Controller
{
    public function getView($id)
    {
        $page = Page::findOrFail($id);
        return view('page.view', compact('page'));
    }

    public function postAdd(PostAddPageFormRequest $request)
    {
        $msg = [];

        try
        {
            $data = $request->only('title', 'content', 'privacy', 'category');
            $data['updated_by'] = auth()->user()->id;

            if (auth()->user()->group->level < 90)
            {
                $data['school_id'] = auth()->user()->school_member->school_id;
            }

            Page::create($data);

            $msg = trans('page.add.success');
        }
        catch (\Exception $e)
        {
            return redirect()->back()->withErrors($e->getMessage());
        }

        return redirect()->back()->with(compact('msg'));
    }

    public function getEdit($id)
    {
        $page = Page::findOrFail($id);
        return view('page.edit', compact('page'));
    }

    public function postEdit(PostEditPageFormRequest $request)
    {
        $msg = [];

        try
        {
            $data = $request->only('title', 'content', 'category', 'privacy');
            Page::findOrFail($request->page_id)->update($data);

            $msg = trans('page.edit.success');
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
            Page::findOrFail($id)->delete();

            $msg = trans('page.delete.success');
        }
        catch (\Exception $e)
        {
            return redirect()->back()->withErrors($e->getMessage());
        }

        return redirect()->home()->with(compact('msg'));
    }
}
