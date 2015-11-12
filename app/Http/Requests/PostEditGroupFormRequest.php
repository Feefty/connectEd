<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Gate;

class PostEditGroupFormRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return ! Gate::denies('update-group');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'          => 'required|min:3|unique:groups,name,'. $this->group_id,
            'level'         => 'required|integer',
            'description'   => 'max:1000'
        ];
    }
}
