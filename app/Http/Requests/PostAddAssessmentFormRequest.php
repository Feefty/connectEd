<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Gate;

class PostAddAssessmentFormRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Gate::allows('create-assessment');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'term'              => 'required|integer',
            'score'             => 'numeric',
            'total'             => 'required|integer',
            'source'            => 'max:255',
            'students'          => 'required',
            'recorded'          => 'integer',
            'date'              => 'required|date',
            'class_subject_id'  => 'required|exists:class_subjects,id',
            
        ];
    }
}
