<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class PostAddClassSubjectLessonFormRequest extends Request
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
            'class_subject_id'      => 'required|exists:class_subjects,id',
            'lesson'                => 'required|exists:lessons,id',
        ];
    }
}
