<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Gate;

class PostAddClassStudentFormRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Gate::allows('create-class-student');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'class_section_id'      => 'required|exists:class_sections,id',
            'username'              => 'required|exists:users,username',
        ];
    }
}
