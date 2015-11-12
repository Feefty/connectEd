<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Gate;

class PostEditAccountUserFormRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return ! Gate::denies('update-user');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'user_id' => 'required|exists:users,id',
            'username' => 'required|max:25|unique:users,username,'. $this->user_id,
            'email' => 'required|email|max:255|unique:users,email,'. $this->user_id,
            'npassword' => 'confirmed|min:6',
            'group' => 'required|integer',
            'status' => 'required|integer'
        ];
    }
}
