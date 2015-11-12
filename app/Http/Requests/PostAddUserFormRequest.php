<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Gate;

class PostAddUserFormRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return ! Gate::denies('add-user');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'username' => 'required|max:25|unique:users',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|confirmed|min:6',
            'first_name' => 'required|min:2|max:255',
            'last_name' => 'required|min:2|max:255',
            'middle_name' => 'min:2|max:255',
            'birthday' => 'date',
            'address' => 'max:255',
            'gender' => 'required|integer'
        ];
    }
}
