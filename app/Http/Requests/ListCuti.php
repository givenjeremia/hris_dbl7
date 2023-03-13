<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;
class ListCuti extends FormRequest
{ public function rules()
    {
        return [
            'page' => 'required',
            'user_id' => 'required',
        ];
    }
    public function failedValidation(Validator $validator)

    {

        throw new HttpResponseException(response()->json([

            'success'   => false,

            'message'   => 'Validation errors',

            'data'      => $validator->errors()

        ]));

    }
        public function messages(){
            return [

                'title.required' => 'Title is required',
    
                'body.required' => 'Body is required'
    
            ];
        }
}
