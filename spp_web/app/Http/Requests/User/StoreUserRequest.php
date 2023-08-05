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
            'email'     =>  'required',
            'roles'     =>  'required',
            'divisions' =>  'required_if:roles,3',
            'villages'  =>  'required_if:roles,4',
        ];
    }
}
