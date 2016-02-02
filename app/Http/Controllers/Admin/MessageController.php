<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Message;

class MessageController extends Controller
{
    public function getData(Request $request)
    {
        $data = [];

        $data['datasets'][0] = [
            'label' => 2016,
            'fillColor' => "rgba(220,220,220,0.2)",
            'strokeColor' => "rgba(220,220,220,1)",
            'pointColor' => "rgba(220,220,220,1)",
            'pointStrokeColor' => "#fff",
            'pointHighlightFill' => "#fff",
            'pointHighlightStroke' => "rgba(220,220,220,1)",
        ];

        foreach (Message::select(\DB::raw('MONTHNAME(created_at) as month'))->whereRaw('YEAR(created_at) = 2016')->orderBy('created_at')->groupBy(\DB::raw('MONTH(created_at)'))->limit(5)->get() as $row)
        {
            $data['labels'][] = $row->month;
            $data['datasets'][0]['data'][] = Message::whereRaw('MONTHNAME(created_at) = "'. $row->month .'" AND YEAR(created_at) = 2016')->count();
        }

        return $data;
    }
}
