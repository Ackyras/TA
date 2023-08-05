<?php

namespace App\Http\Requests\Farmer;

use Illuminate\Foundation\Http\FormRequest;

class StoreFarmerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->user()->can('farmers.create');
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
            'name'          =>  ['required', 'unique:farmers,name'],
            'village_id'    =>  ['required', 'exists:villages,id'],
            'pic'           =>  ['required'],
            'address'       =>  ['required'],
        ];
    }
}
