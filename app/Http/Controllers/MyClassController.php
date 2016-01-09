<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\ClassSubject;

class MyClassController extends Controller
{
    public function getIndex()
    {
    	return view('myclass.index');
    }
}
