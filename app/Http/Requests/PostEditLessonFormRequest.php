<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Gate;

class PostEditLessonFormRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Gate::allows('update-lesson');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'lesson_id' => 'required|exists:lessons,id',
            'title'     => 'required|max:255',
            'content'   => 'required',
            'subject'   => 'required|exists:subjects,id',
            'file'      => 'array|each:max:50000'
        ];
    }
}
