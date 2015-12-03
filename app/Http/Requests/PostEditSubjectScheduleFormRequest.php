<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Gate;

class PostEditSubjectScheduleFormRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Gate::allows('update-subject-schedule');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'id'                => 'required|exists:subject_schedules,id',
            'day'               => 'required|integer',
            'time_start'        => 'required',
            'time_end'          => 'required'
        ];
    }
}
