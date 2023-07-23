<?php

namespace App\Rules;

use App\Models\Period;
use Illuminate\Contracts\Validation\Rule;

class DateRangeNotOverlap implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {

        // Check if the current period overlaps with any existing periods
        $overlappingPeriods = Period::where(function ($query) use ($value) {
            $query->where('start_date', '<=', $value)
                ->where('end_date', '>=', $value);
        })->exists();

        return !$overlappingPeriods;
    }

    public function message()
    {
        return 'The date range overlaps with an existing period.';
    }
}
