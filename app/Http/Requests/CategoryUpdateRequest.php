<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryUpdateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
          'name'=> 'required|string|min:5|max:100',
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
