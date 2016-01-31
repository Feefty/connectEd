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
            'quarter'           => 'required|integer',
            'score'             => 'required|integer',
            'total'             => 'required|integer',
            'source'            => 'max:255|required_without:other',
            'other'             => 'max:255|required_without:source',
            'students'          => 'required',
            'recorded'          => 'integer',
            'date'              => 'required|date',
            'class_subject_id'  => 'required|exists:class_subjects,id',
            'assessment_category_id' => 'required|exists:assessment_categories,id',

        ];
    }
}
