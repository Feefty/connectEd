<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class PostAddGradeSummaryFormRequest extends Request
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
            'student_id'        => 'required|exists:users,id',
            'quarter'           => 'required|integer',
            'school_year'       => 'required|integer',
            'class_subject_id'  => 'required|exists:class_subjects,id'
        ];
    }
}
