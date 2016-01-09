<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Gate;

class PostAddExamQuestionAnswerFormRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Gate::allows('create-exam-question-answer');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'exam_question_id'      => 'required|exists:exam_questions,id',
            'answer'                => 'required|array|each:max:255',
            'points'                => 'required|array|each:max:100|each:min:0'
        ];
    }
}
