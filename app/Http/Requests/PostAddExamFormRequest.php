<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class PostAddExamFormRequest extends Request
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
            'title'         => 'required|max:255',
            'exam_type'     => 'required|exists:exam_types,id',
            'subject'       => 'required|exists:subjects,id',
        ];
    }
}
