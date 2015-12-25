<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class PostEditExamQuestionAnswerEditFormRequest extends Request
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
            'exam_question_answer_id' => 'required|exists:exam_question_answers,id',
            'answer'            => 'required|max:255',
            'points'            => 'integer|min:0|max:100'
        ];
    }
}
