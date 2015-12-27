<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class PostAddClassSubjectExamFormRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'exam'          => 'required|exists:exams,id',
            'start_date'    => 'required|date_format:Y-m-d',
            'start_time'    => 'required|date_format:H:i',
            'end_date'      => 'required|date_format:Y-m-d',
            'end_time'      => 'required|date_format:H:i',
        ];
    }
}
