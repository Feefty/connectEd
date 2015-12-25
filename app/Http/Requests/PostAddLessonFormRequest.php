<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class PostAddLessonFormRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'title'     => 'required|max:255',
            'content'   => 'required',
            'subject'   => 'required|exists:subjects,id',
            'file'      => 'array|each:max:50000'
        ];

        // $nbr = count($this->input('file')) - 1;

        // foreach (range(0, $nbr) as $index)
        // {
        //     $rules['file.'. $index] = 'max:5';
        // }

        return $rules;
    }
}
