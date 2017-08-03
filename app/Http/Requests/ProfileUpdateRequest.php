<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Auth;

class ProfileUpdateRequest extends FormRequest
{

    // Determine if the user is authorized to make this request.

    public function authorize()
    {
        return true;
    }

    // Get the validation rules that apply to the request.

    public function rules()
    {
        return [
          'name' => 'required|string|max:255',
          //'username' => 'required|string|alpha_dash|max:255',
          //'username' => Rule::unique('one_users')->ignore(Auth::id()),
                ///----- OR ------///
          'username' => ['required', 'string', 'alpha_dash', 'max:255',
                          Rule::unique('one_users')->ignore(Auth::id()),
                        ],//every element in this array should be one rule only
          'email' => ['required', 'email', 'max:255',
                          Rule::unique('one_users')->ignore(Auth::id()),
                        ],
          'avatar' => 'sometimes|image',
        ];
    }
}
