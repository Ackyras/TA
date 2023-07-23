<?php

namespace App\Http\Requests\Period;

use App\Rules\DateRangeNotOverlap;
use Illuminate\Foundation\Http\FormRequest;

class StorePeriodRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->user()->can('periods.create');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => 'required',
            'start_date' => [
                'required',
                'date',
                'before_or_equal:end_date', // Ensure start_date is before or equal to end_date
                new DateRangeNotOverlap($this->end_date)
            ],
            'end_date' => [
                'required',
                'date',
                'after_or_equal:start_date', // Ensure end_date is after or equal to start_date
                new DateRangeNotOverlap($this->start_date)
            ],
            'deactivate_active_period' => 'accepted'
        ];
    }
}
