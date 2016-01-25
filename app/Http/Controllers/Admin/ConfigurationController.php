<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests\PostUpdateConfigurationFormRequest;
use App\Http\Controllers\Controller;
use App\Configuration;

class ConfigurationController extends Controller
{
    public function getIndex()
    {
        $configs = [];
        foreach (Configuration::get() as $row)
        {
            $configs[$row->name] = $row->value;
        }

        return view('admin.configuration.index', compact('configs'));
    }

    public function postUpdate(PostUpdateConfigurationFormRequest $request)
    {
        $msg = [];

        try
        {
            $data = $request->only('1_quarter_date_from', '1_quarter_date_to',
                                '2_quarter_date_from', '2_quarter_date_to',
                                '3_quarter_date_from', '3_quarter_date_to',
                                '4_quarter_date_from', '4_quarter_date_to');

            foreach ($data as $row => $col)
            {
                $configuration = Configuration::where('name', $row);

                if ($configuration->exists())
                {
                    $configuration->update(['value' => $col]);
                }
                else
                {
                    Configuration::create(['name' => $row, 'value' => $col]);
                }
            }

            $msg = trans('configuration.update.success');
        }
        catch (\Exception $e)
        {
            return redirect()->back()->withErrors($msg);
        }

        return redirect()->back()->with(compact('msg'));
    }
}
