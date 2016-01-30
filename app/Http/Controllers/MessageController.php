<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\PostAddMessageFormRequest;
use App\Http\Controllers\Controller;
use App\Message;
use App\User;

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

        return $message->groupBy('from_id')->orderBy('created_at', 'desc')->get();
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
            $data = $request->only('content', 'to_id');
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

    public function postSend(PostAddMessageFormRequest $request)
    {
        $data = $request->only('content', 'to_id');
        $data['from_id'] = $request->user()->id;

        $message = Message::create($data);

        return [
            'status' => 'success',
            'id' => $message->id,
            'content' => nl2br(e($data['content'])),
            'created_at' => (string) $message->created_at,
            'timeago' => $message->created_at->diffForHumans(),
            'username' => $message->from->username,
            'name' => ucwords(strtolower($message->from->profile->first_name .' '. $message->from->profile->last_name))
        ];
    }

    public function getView($username)
    {
        if ($username == auth()->user()->username)
        {
            abort(404);
        }

        $to_id = User::where('username', $username)->pluck('id');

        $messages = Message::where(function($query) use($username) {
            $query->whereHas('from', function($query) use($username) {
                $query->where('username', $username);
            })
            ->where('to_id', auth()->user()->id);
        })
        ->orWhere(function($query) use($username) {
            $query->whereHas('to', function($query) use($username) {
                $query->where('username', $username);
            })
            ->where('from_id', auth()->user()->id);
        })
        ->orderBy('created_at')
        ->get();

        Message::where(function($query) use($username) {
           $query->whereHas('from', function($query) use($username) {
               $query->where('username', $username);
           })
           ->where('to_id', auth()->user()->id);
       })
       ->orWhere(function($query) use($username) {
           $query->whereHas('to', function($query) use($username) {
               $query->where('username', $username);
           })
           ->where('from_id', auth()->user()->id);
       })->update(['read' => 1]);

       $message_to = User::findOrFail($to_id);

        return view('message.view', compact('messages', 'to_id', 'message_to'));
    }
}
