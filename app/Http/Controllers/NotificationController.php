<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Notification;

class NotificationController extends Controller
{
	public function getApi(Request $request)
	{
		$notification = Notification::with('target')
									->where('target_id', auth()->user()->id)
									->where('read', 0)
									->orderBy('created_at', 'desc')
									->get();

		return $notification;
	}

    public function getIndex()
    {
    	return view('notification.index');
    }
}
