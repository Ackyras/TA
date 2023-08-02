<?php

namespace App\Http\Requests\Request;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequestRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->user()->can('requests.update');
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
            'program_id' => 'filled',
            'volume' => 'filled',
            'unit_id' => 'filled',
            'attachments' => 'filled|array',
            'attachments.*.name' => 'filled',
            'attachments.*.file' => 'filled|file',
            'status'    =>  'filled',
        ];
    }
}
