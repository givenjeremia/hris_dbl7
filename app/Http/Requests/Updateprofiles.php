<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

use Illuminate\Http\Exceptions\HttpResponseException;

use Illuminate\Contracts\Validation\Validator;

class Updateprofiles extends FormRequest
{
    
    public function rules()
    {
        return [
            'user_nama' => 'required',
            'user_id' => 'required',
            'user_no_hp' => 'required',
        ];
    }
    public function failedValidation(Validator $validator)

    {

        throw new HttpResponseException(response()->json([

            'success'   => false,

            'message'   => 'Validation errors',

            'data'      => $validator->errors()

        ],400));

    }
        public function messages(){
            return [

                'title.required' => 'Title is required',
    
                'body.required' => 'Body is required'
    
            ];
        }
    
}
