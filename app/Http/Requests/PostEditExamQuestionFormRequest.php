<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Gate;

class PostEditExamQuestionFormRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Gate::allows('update-exam-question');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'exam_question_id'  => 'required|exists:exam_questions,id',
            'question'          => 'required',
            'time_limit'        => 'integer'
        ];
    }
}
