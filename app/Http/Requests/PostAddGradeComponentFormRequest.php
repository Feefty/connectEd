<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class PostAddGradeComponentFormRequest extends Request
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
            'level'                 => 'required|array',
            'subject_id'            => 'required|exists:subjects,id',
            'percentage'            => 'required|max:100|integer',
            'assessment_category_id'=> 'required|exists:assessment_categories,id',
            'color'                 => 'required|max:255'
        ];
    }
}
