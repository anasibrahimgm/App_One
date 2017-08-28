<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Auth;

class PostStoreRequest extends FormRequest
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
          'title' => 'required|string|min:5|max:255',
          'category' => 'required|integer',
          'slug' => 'required|alpha_dash|min:5|max:255|unique:one_posts,slug',
          'body' => 'required|string',
        ];
    }

    public function messages()
    {
      return [
        'title.min' => 'That\'s too short',
      ];
    }
}
