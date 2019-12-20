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
            'username' => 'required|unique:auth_users|max:50',
            'email' => 'required|email|unique:auth_users|max:191',
            'phone_number' => 'required|numeric|',
            'district_id' => 'required|numeric|exists:bs_districts,id',
            'password' => 'required'
        ];
    }

    public function attributes()
    {
        return [
            'first_name' => __('attributes.first_name'),
            'last_name' => __('attributes.last_name'),
            'username' => __('attributes.username'),
            'email' => __('attributes.email'),
            'phone_number' => __('attributes.phone_number'),
            'district_id' => __('attributes.district'),
            'password' => __('attributes.password'),
        ];
    }
}
