<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\PostAddLessonFormRequest;
use App\Http\Requests\PostEditLessonFormRequest;
use App\Http\Controllers\Controller;
use App\Subject;
use App\Lesson;
use App\LessonFile;
use App\SchoolMember;
use File;
use Validator;
use Storage;
use Response;

class LessonController extends Controller
{
	public function getApi(Request $request)
	{
		$lesson = Lesson::select('lessons.*', 'subjects.name as subject', \DB::raw('CONCAT(profiles.first_name, " ", profiles.last_name) as posted_by'))
							->leftJoin('subjects', 'subjects.id', '=', 'lessons.subject_id')
							->leftJoin('profiles', 'profiles.user_id', '=', 'lessons.posted_by');

		if ($request->has('school_id'))
		{
			$lesson = $lesson->where('lessons.school_id', (int) $request->school_id);
		}

		return $lesson->with('file')
						->get();
	}

    public function getIndex()
    {
    	$subjects = Subject::orderBy('name', 'asc')
    						->get();
    	$school_id = SchoolMember::where('user_id', auth()->user()->id)
    						->pluck('school_id');
    	return view('lesson.index', compact('subjects', 'school_id'));
    }

    public function getView($lesson_id)
    {
    	$lesson = Lesson::select('schools.name as school_name', 'subjects.*', 'lessons.*', 'subjects.name as subject', \DB::raw('CONCAT(profiles.first_name, " ", profiles.last_name) as posted_by'))
    						->leftJoin('subjects', 'subjects.id', '=', 'lessons.subject_id')
    						->leftJoin('schools', 'schools.id', '=', 'lessons.school_id')
    						->leftJoin('profiles', 'profiles.user_id', '=', 'lessons.posted_by')
    						->findOrFail($lesson_id);

    	return view('lesson.view', compact('lesson'));
    }

    public function getFile($file_id)
    {
    	$lesson_file = LessonFile::leftJoin('lessons', 'lessons.id', '=', 'lesson_files.lesson_id')
    							->findOrFail($file_id);
    	$file = config('lesson.file.path').$lesson_file->subject_id.'/'.$lesson_file->file_name;
    	
    	$fs = Storage::getDriver();
    	$stream = $fs->readStream($file);

    	return Response::stream(function() use($stream) {
    		fpassthru($stream);
    	}, 200, [
    		"Content-Type" => $fs->getMimetype($file),
    		"Content-Length" => $fs->getSize($file),
			"Content-disposition" => "attachment; filename=\"" . basename($file) . "\"",
    	]);
    }

    public function getDelete($id)
    {
        $msg = [];

        try
        {
        	$lesson = Lesson::findOrFail($id);
	    	$lesson->file()->delete();
	    	$lesson->delete();
            
            $msg = trans('lesson.delete.success');
        }
        catch (\Exception $e)
        {
            return redirect()->back()->withErrors($e->getMessage());
        }

        return redirect()->back()->with(compact('msg'));
    }

    public function getDeleteFile($id)
    {
        $msg = [];

        try
        {
        	LessonFile::findOrFail($id)->delete();
    		$lesson_files = LessonFile::select('lesson_files.*', 'lessons.subject_id')
    								->leftJoin('lessons', 'lessons.id', '=', 'lesson_files.lesson_id')
    								->findOrFail($id);

    		Storage::delete(config('lesson.file.path').$lesson_files->subject_id .'/'. $lesson_files->file_name);

            
            $msg = trans('lesson.delete.success');
        }
        catch (\Exception $e)
        {
            return redirect()->back()->withErrors($e->getMessage());
        }

        return redirect()->back()->with(compact('msg'));
    }

    public function getEdit($id)
    {
    	$lesson = Lesson::with('file')
    						->findOrFail($id);
    	$subjects = Subject::orderBy('name')
    						->get();
    	return view('lesson.edit', compact('lesson', 'subjects'));
    }

    public function postEdit(PostEditLessonFormRequest $request)
    {
        $msg = [];

        try
        {
            $data = $request->only('title', 'content');
            $data['subject_id'] = (int) $request->subject;

            $lesson = Lesson::findOrFail($request->lesson_id);
            $lesson->update($data);

            // uploading files
            if ($request->hasFile('file'))
            {
           		$data_file = [];
            	$files = $request->file('file');
            	$uploader = (int) $request->user()->id;

            	foreach ($files as $file)
            	{
            		$path = config('lesson.file.path');
            		$file_name = time() .'-'. $file->getClientOriginalName();
            		$name = $file->getClientOriginalName();

            		Storage::put($path.$request->subject.'/'.$file_name, file_get_contents($file->getRealPath()));
            		
            		$data_file[] = [
            			'name'		=> $name,
            			'file_name'	=> $file_name,
            			'added_by'	=> $uploader,
            			'created_at'=> new \DateTime,
            			'lesson_id'	=> $lesson->id
            		];
            	}

            	LessonFile::insert($data_file);
            }
            
            $msg = trans('lesson.edit.success');
        }
        catch (\Exception $e)
        {
            return redirect()->back()->withErrors($e->getMessage());
        }

        return redirect()->back()->with(compact('msg'));
    }

    public function postAdd(PostAddLessonFormRequest $request)
    {
        $msg = [];

        try
        {
            $data = $request->only('title', 'content');
            $data['subject_id'] = (int) $request->subject;
            $data['posted_by'] = (int) $request->user()->id;
            $data['school_id'] = (int) $request->school_id;

            $lesson = Lesson::create($data);

            // uploading files
            if ($request->hasFile('file'))
            {
           		$data_file = [];
            	$files = $request->file('file');

            	foreach ($files as $file)
            	{
            		$path = config('lesson.file.path');
            		$file_name = time() .'-'. $file->getClientOriginalName();
            		$name = $file->getClientOriginalName();

            		Storage::put($path.$request->subject.'/'.$file_name, file_get_contents($file->getRealPath()));
            		
            		$data_file[] = [
            			'name'		=> $name,
            			'file_name'	=> $file_name,
            			'added_by'	=> $data['posted_by'],
            			'created_at'=> new \DateTime,
            			'lesson_id'	=> $lesson->id
            		];
            	}

            	LessonFile::insert($data_file);
            }
            
            $msg = trans('lesson.add.success');
        }
        catch (\Exception $e)
        {
            return redirect()->back()->withErrors($e->getMessage());
        }

        return redirect()->back()->with(compact('msg'));
    }
}
