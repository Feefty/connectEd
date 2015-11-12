<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Gate;

class PostSaveSettingsEmailFormRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return ! Gate::denies('email-settings');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email' => 'required|email|max:255|unique:users,email,'. $this->user()->id,
            'cpassword' => 'required'
        ];
    }
}
