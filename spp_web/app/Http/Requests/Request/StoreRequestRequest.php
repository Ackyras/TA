<?php

namespace App\Http\Requests\Request;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequestRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->user()->can('requests.store');
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
            'farmer_id' => 'required',
            'program_id' => 'required',
            'volume' => 'required',
            'unit_id' => 'required',
            'attachments' => 'required|array',
            'attachments.*.name' => 'required',
            'attachments.*.file' => 'required|file',
        ];
    }
}
