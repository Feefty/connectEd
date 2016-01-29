<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\PostAddMessageFormRequest;
use App\Http\Controllers\Controller;
use App\Message;

class MessageController extends Controller
{
    public function getApi(Request $request)
    {
        $message = Message::with('from.profile');

        if ($request->has('group_message_id'))
        {

        }
        else
        {
            $message = $message->where('to_id', auth()->user()->id);
        }

        return $message->orderBy('created_at', 'desc')->get();
    }

    public function getUnread()
    {
        return ["unread" => Message::where('to_id', auth()->user()->id)->where('read', 0)->get()->count()];
    }

    public function getIndex()
    {
        return view('message.index');
    }

    public function postAdd(PostAddMessageFormRequest $request)
    {
        $msg = [];

        try
        {
            $data = $request->only('subject', 'content', 'to_id');
            $data['from_id'] = $request->user()->id;

            Message::create($data);

            $msg = trans('message.add.success');
        }
        catch (\Exception $e)
        {
            return redirect()->back()->withErrors($e->getMessage());
        }

        return redirect()->back()->with(compact('msg'));
    }
}
