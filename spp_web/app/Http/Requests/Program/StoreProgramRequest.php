<?php

namespace App\Http\Requests\Program;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class StoreProgramRequest extends FormRequest
{
    public function prepareForValidation()
    {
    }
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        // dd($this->input());
        return [
            'code' => ['required_if:is_parent,true', 'string'],
            'name' => ['required', 'string'],
            'parent_id' => 'filled',
        ];
    }
}
