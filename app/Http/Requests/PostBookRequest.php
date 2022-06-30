<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostBookRequest extends FormRequest
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
        // @TODO implement
        $rules = [
            'isbn'          =>  'required',
            'title'         =>  'required',
            'description'   =>  'required',
            'authors'        =>  'required',
            'published_year'=>  'required',
        ];

        return $rules;
    }

    function messages()
    {
        $text =  " required";
        $message = [
            'isbn.required'          =>  'isbn required',
            'title.required'         =>  'tittle required',
            'description.required'   =>  'description required',
            'authors.required'        =>  'authors required',
            'published_year.required'=>  'publis year required',
        ];

        return $message;
    }
}
