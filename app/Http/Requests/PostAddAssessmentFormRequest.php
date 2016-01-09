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
            'subject'           => 'required|exists:subjects,id',
            'term'              => 'required|integer',
            'score'             => 'numeric',
            'total'             => 'required|integer',
            'source'            => 'max:255',
            'student'           => 'required|exists:users,id'
        ];
    }
}
