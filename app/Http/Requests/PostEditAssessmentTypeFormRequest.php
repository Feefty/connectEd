<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class PostEditAssessmentTypeFormRequest extends Request
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
            'assessment_type_id'        => 'required|exists:assessment_types,id',
            'name'                      => 'required|unique:assessment_types,name,'. $this->assessment_type_id,
            'status'                    => 'integer'
        ];
    }
}
