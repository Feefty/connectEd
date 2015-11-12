<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class GradeController extends Controller
{
    public function getIndex()
    {
    	return view('admin.grade.index');
    }
}
