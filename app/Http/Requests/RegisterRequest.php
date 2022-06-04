<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'firstName'=>'required|max:255',
            'lastName'=>'required|max:255',
            'email'=>'required|email|unique:users',
            'password'=>'required|min:6|regex:/[0-9]/|confirmed',
            'terms'=>'accepted'
        ];
    }
}
