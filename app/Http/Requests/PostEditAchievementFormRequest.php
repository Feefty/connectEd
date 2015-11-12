<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Gate;

class PostEditAchievementFormRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return ! Gate::denies('update-achievement');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'achievement_id' => 'required|exists:achievements,id',
            'title'          => 'required|max:255|unique:achievements,title,'. $this->achievement_id
        ];
    }
}
