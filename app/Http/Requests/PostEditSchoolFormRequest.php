<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Gate;

class PostEditSchoolFormRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return ! Gate::denies('update-school');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'school_id'     => 'required|exists:schools,id',
            'name'          => 'required|min:3|max:255|unique:schools,name,'. $this->school_id,
        ];
    }
}
