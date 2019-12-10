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
     * @return array
     */
    public function rules()
    {
        return [
            'first_name' => 'required|max:100',
            'last_name' => 'required|max:100',
            'username' => 'required|max:50',
            'email' => 'required|unique:auth_users|email|max:191',
            'phone_number' => 'required|numeric|max:20',
            'district_id' => 'required|numeric|exists:bs_districts,id',
        ];
    }
}
