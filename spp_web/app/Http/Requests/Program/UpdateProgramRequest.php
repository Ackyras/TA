<?php

namespace App\Http\Requests\Program;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProgramRequest extends FormRequest
{
    public function prepareForValidation()
    {
        $this->merge(
            [
                'is_parent' =>  $this->input('is_parent') ? $this->input('is_parent') : false,
            ]
        );
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
        return [
            //
            'name'          =>  'required',
            'is_parent'     =>  [
                'nullable',
                function ($attribute, $value, $fail) {
                    $hasSubprograms = request()->route()->parameter('program')->subPrograms()->exists();
                    if ($hasSubprograms && !$value) {
                        $fail('Program ini memiliki sub program, hapus terlebih dahulu sub program lainnya.');
                    }
                }
            ],
        ];
    }
}
