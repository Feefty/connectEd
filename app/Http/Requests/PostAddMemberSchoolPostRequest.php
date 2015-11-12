<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Gate;

class PostAddMemberSchoolPostRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return ! Gate::denies('add-member-school');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'school_id'         => 'required|exists:schools,id',
            'username'          => 'required|exists:users,username'
        ];
    }
}
