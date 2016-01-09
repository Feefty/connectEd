<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Gate;

class PostAddExamQuestionFormRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Gate::allows('create-exam-question');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'category'          => 'required',
            'exam_id'           => 'required|exists:exams,id',
            'question'          => 'required',
            'time_limit'        => 'min:0',
            'answer'            => 'required|array|each:max:255',
            'points'            => 'required|array|each:max:100|each:min:0'
        ];
    }
}
