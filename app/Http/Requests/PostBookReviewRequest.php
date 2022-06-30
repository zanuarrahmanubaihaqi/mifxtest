<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostBookReviewRequest extends FormRequest
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
            'review'   =>  'required',
            'comment'  =>  'required',
        ];

        return $rules;
    }

    function messages()
    {
        $text =  " required";
        $message = [
            'review.required'   =>  'review required',
            'comment.required'  =>  'comment required',
        ];

        return $message;
    }
}
