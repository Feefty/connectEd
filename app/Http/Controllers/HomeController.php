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
        if (auth()->check() && auth()->user()->group->level != 99 && auth()->user()->status != 0)
        {
        	$school_id = (int) auth()->user()->school_member->school_id;
        	$news = Page::where('school_id', $school_id)->where('category', 'news_&_events')->orderBy('created_at', 'desc')->get();
        	$announcements = Page::where('school_id', $school_id)->where('category', 'announcements')->orderBy('created_at', 'desc')->get();
        }
        else
        {
            $news = Page::where('school_id', 0)->where('category', 'news_&_events')->orderby('created_at', 'desc')->get();
            $announcements = Page::where('school_id', 0)->where('category', 'announcements')->orderby('created_at', 'desc')->get();
        }

    	return view('home.index', compact('news', 'announcements'));
    }
}
