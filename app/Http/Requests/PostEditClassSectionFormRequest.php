<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Gate;

class PostEditClassSectionFormRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Gate::allows('update-class-section');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'id'                => 'required|exists:class_sections,id',
            'name'              => 'required',
            'adviser'           => 'required|exists:users,id',
            'level'             => 'required|integer',
            'year'              => 'required|integer',
            'status'            => ''
        ];
    }
}
