<?php

namespace App\Http\Requests\District;

use Illuminate\Foundation\Http\FormRequest;

class StoreDistrictRequest extends FormRequest
{
    protected function prepareForValidation(): void
    {
        if (empty($this->input('with_user'))) {
            $this->merge([
                'with_user' => false,
            ]);
        }
    }


    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->user()->can('districts.create');
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
            'name'  =>  ['required'],
            'with_user' =>  ['nullable', 'boolean']
        ];
    }
}
