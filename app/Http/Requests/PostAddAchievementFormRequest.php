<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Gate;

class PostAddAchievementFormRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return ! Gate::denies('create-achievement');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title'         => 'required|max:255|unique:achievements',
        ];
    }
}
