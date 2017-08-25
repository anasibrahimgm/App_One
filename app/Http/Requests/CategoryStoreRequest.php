<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryStoreRequest extends FormRequest
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
            'name'=> 'required|string|min:5|max:100|unique:one_categories,name',
            'description'=> 'required|string|min:5|max:255',
        ];
    }

    public function messages()
    {
      return [
        'description.required' => 'You must provide a description for the Category',
      ];
    }
}
