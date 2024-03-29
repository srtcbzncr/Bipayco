<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CourseRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'image' => 'mimes:jpeg,jpg,png|required|max:10000', // 10000 kb = 10 mb
            'name' => 'required|max:100',
            'description' => 'required|max:255',
            'access_time' => 'required',
            'certificate'=> 'required',
            'price' => 'required',
            'category_id'=>'required',
            'sub_category_id'=>'required'
        ];
    }
}
