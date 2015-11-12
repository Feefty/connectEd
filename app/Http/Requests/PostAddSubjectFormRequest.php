<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Gate;

class PostAddSubjectFormRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return ! Gate::denies('create-subject');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'          => 'required|max:255',
            'code'          => 'required|max:255'
        ];
    }
}
