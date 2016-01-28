<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests\PostAddQuarterCalendarFormRequest;
use App\Http\Requests\PostEditQuarterCalendarFormRequest;
use App\Http\Controllers\Controller;
use App\QuarterCalendar;

class QuarterCalendarController extends Controller
{
    public function getApi()
    {
        return QuarterCalendar::orderBy('created_at', 'desc')->groupBy('school_year')->get();
    }

    public function getIndex()
    {
        return view('admin.quarter_calendar.index');
    }

    public function getEdit($school_year)
    {
        if ( ! QuarterCalendar::where('school_year', $school_year)->exists())
        {
            die(404);
        }

        $quarter_calendar = [];
        foreach (QuarterCalendar::where('school_year', $school_year)->get() as $row)
        {
            $quarter_calendar['quarter_'. $row->quarter] = [
                'date_from' => $row->date_from,
                'date_to' => $row->date_to
            ];
        }

        return view('admin.quarter_calendar.edit', compact('quarter_calendar', 'school_year'));
    }

    public function postEdit(PostEditQuarterCalendarFormRequest $request)
    {
        $msg = [];

        try
        {
            for ($i = 1; $i <= 4; $i++)
            {
                $data = [];
                $data['date_from'] = $request->{'quarter_'.$i.'_from'};
                $data['date_to'] = $request->{'quarter_'.$i.'_to'};
                QuarterCalendar::where('school_year', (int) $request->school_year)->where('quarter', $i)->update($data);
            }

            $msg = trans('quarter_calendar.edit.success');
        }
        catch (\Exception $e)
        {
            return redirect()->back()->withErrors($msg);
        }

        return redirect()->back()->with(compact('msg'));
    }

    public function postAdd(PostAddQuarterCalendarFormRequest $request)
    {
        $msg = [];

        try
        {
            $data = [];

            for ($i = 1; $i <= 4; $i++)
            {
                $data[$i-1]['school_year'] = (int) $request->school_year;
                $data[$i-1]['quarter'] = $i;
                $data[$i-1]['date_from'] = $request->{'quarter_'.$i.'_from'};
                $data[$i-1]['date_to'] = $request->{'quarter_'.$i.'_to'};
                $data[$i-1]['created_at'] = new \DateTime;
            }

            QuarterCalendar::insert($data);

            $msg = trans('quarter_calendar.add.success');
        }
        catch (\Exception $e)
        {
            return redirect()->back()->withErrors($msg);
        }

        return redirect()->back()->with(compact('msg'));
    }

    public function getDelete($year)
    {
        $msg = [];

        try
        {
            QuarterCalendar::where('school_year', (int) $year)->delete();

            $msg = trans('quarter_calendar.delete.success');
        }
        catch (\Exception $e)
        {
            return redirect()->back()->withErrors($msg);
        }

        return redirect()->back()->with(compact('msg'));
    }
}
