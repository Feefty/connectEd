<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Page;

class HomeController extends Controller
{
    public function getIndex()
    {	
    	$school_id = (int) auth()->user()->school_member->school_id;
    	$news = Page::where('school_id', $school_id)->where('category', 'news_&_events')->orderBy('created_at', 'desc')->get();
    	$announcements = Page::where('school_id', $school_id)->where('category', 'announcements')->orderBy('created_at', 'desc')->get();
    	return view('home.index', compact('news', 'announcements'));
    }
}
