<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InstructorRequest extends FormRequest
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
            'school_id'=>'max:100',
            'user_id'=>'max:100',
            'identification_number'=>'required|max:100',
            'title'=>'required|max:100',
            'iban'=>'required|min:24|max:34',
            'bio'=>'required|max:255',
            'reference_code'=>'max:18'
        ];
    }
}
