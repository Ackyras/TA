<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->user()->can('users.create');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            //
            'name'      =>  'required',
            'password'  =>  ['required', 'string', 'min:6', 'max:12'],
            'email'     =>  ['required', 'email'],
            'roles'     =>  'required',
            'divisions' =>  'required_if:roles,2',
            'villages'  =>  'required_if:roles,3',
        ];
    }

    protected function passedValidation()
    {
        $this->replace(
            [
                'password' => bcrypt($this->password)
            ]
        );
    }
}
