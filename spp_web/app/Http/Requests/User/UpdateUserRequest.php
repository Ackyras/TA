<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->user()->can('users.update');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name'      => 'required',
            'email'     => 'required',
            'roles'     => ['required', 'array'],
            'divisions' => ['nullable', function ($attribute, $value, $fail) {
                if (empty($value) && request()->has('roles') && !in_array('1', request()->input('roles')) && !in_array('2', request()->input('roles')) && !in_array('3', request()->input('roles'))) {
                    return $fail('The ' . $attribute . ' field is required.');
                }
            }],
            'villages'  => ['nullable', function ($attribute, $value, $fail) {
                if (empty($value) && request()->has('roles') && !in_array('1', request()->input('roles')) && !in_array('2', request()->input('roles')) && !in_array('4', request()->input('roles'))) {
                    return $fail('The ' . $attribute . ' field is required.');
                }
            }]
        ];
    }
}
