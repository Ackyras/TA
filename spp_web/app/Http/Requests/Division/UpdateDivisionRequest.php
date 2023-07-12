<?php

namespace App\Http\Requests\Division;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDivisionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->user()->can('divisions.update');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        $divisionId = $this->route('division')->id;
        return [
            //
            'name'      =>  'required',
            'nickname'  =>  ['required', 'unique:divisions,nickname,' . $divisionId]
        ];
    }
}
