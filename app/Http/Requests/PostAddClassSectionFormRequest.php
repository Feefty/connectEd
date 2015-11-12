<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Gate;

class PostAddClassSectionFormRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Gate::allows('create-class-section');
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
            'adviser'       => 'required|exists:users,id',
            'status'        => 'required|boolean',
            'year'          => 'required|integer',
        ];
    }
}
