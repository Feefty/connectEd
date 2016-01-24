<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\PostAddPageFormRequest;
use App\Http\Controllers\Controller;
use App\Page;

class PageController extends Controller
{
    public function postAdd(PostAddPageFormRequest $request)
    {
        $msg = [];

        try
        {
            $data = $request->only('title', 'content', 'privacy', 'category');
            $data['updated_by'] = auth()->user()->id;
            $data['school_id'] = auth()->user()->school_member->school_id;

            Page::create($data);
            
            $msg = trans('page.add.success');
        }
        catch (\Exception $e)
        {
            return redirect()->back()->withErrors($msg);
        }

        return redirect()->back()->with(compact('msg'));
    }
}
