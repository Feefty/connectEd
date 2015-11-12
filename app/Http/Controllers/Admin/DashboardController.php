<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Gate;

class DashboardController extends Controller
{
    public function getIndex()
    {
    	if (Gate::denies('read-dashboard'))
    	{
    		return abort(401);
    	}
    	
        return view('admin.dashboard.index');
    }
}
