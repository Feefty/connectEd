<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Notification;

class NotificationController extends Controller
{
    public function getIndex()
    {
    	return view('notification.index');
    }
}
