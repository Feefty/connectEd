<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class PostAddQuarterCalendarFormRequest extends Request
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
            'quarter_1_from'            => 'required|date|before:quarter_1_to',
            'quarter_1_to'              => 'required|date|after:quarter_1_from',
            'quarter_2_from'            => 'required|date|after:quarter_1_to',
            'quarter_2_to'              => 'required|date|after:quarter_2_from',
            'quarter_3_from'            => 'required|date|after:quarter_2_to',
            'quarter_3_to'              => 'required|date|after:quarter_3_from',
            'quarter_4_from'            => 'required|date|after:quarter_3_to',
            'quarter_4_to'              => 'required|date|after:quarter_4_from',
            'school_year'               => 'required|integer|digits:4|unique:quarter_calendar,school_year'
        ];
    }
}
