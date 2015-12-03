<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Gate;

class PostAddClassSubjectScheduleFormRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Gate::allows('create-class-subject');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'subject'       => 'required|exists:subjects,id',
            'teacher'       => 'required|exists:users,id',
            'room'          => 'required|max:55',
            'day'           => 'array',
            'time_start'    => 'array',
            'time_end'      => 'array'
        ];
    }
}
