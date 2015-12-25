<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\ExamType;

class ExamController extends Controller
{
    public function getIndex()
    {
    	return view('admin.exam.index');
    }
}
