<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PostUpdateRequest extends FormRequest
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
      //$post = $this->route()->input('post');
        return [
          'title' => 'required|string|min:5|max:255',
          'slug' => ['required','alpha_dash','min:5','max:255'],
          'body' => 'required|string',
        ];
    }
}
