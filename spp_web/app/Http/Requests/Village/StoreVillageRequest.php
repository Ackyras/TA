<?php

namespace App\Http\Requests\Village;

use Illuminate\Foundation\Http\FormRequest;

class StoreVillageRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->user()->can('villages.create');
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
            'name'          =>  ['required', 'unique:villages,name'],
            'district_id'   =>  ['required', 'exists:districts,id'],
        ];
    }
}
