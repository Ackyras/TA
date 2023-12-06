<?php

namespace App\Http\Requests\Request\Result;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequestResultRequest extends FormRequest
{
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
            'request_id'    =>  'required',
            'volume' => 'required',
            'attachments'               => ['nullable', 'array'],
            'attachments.*.name'        => ['required_with:attachments.*.file'],
            'attachments.*.file'        => ['filled', 'file', 'mimes:png,jpg,pdf', 'required_with:attachments.*.name'],
        ];
    }
}