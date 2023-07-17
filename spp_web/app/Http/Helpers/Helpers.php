<?php

use App\Models\Period;

if (!function_exists('getCurrentPeriod')) {
    function getCurrentPeriod(): ?Period
    {
        return Period::query()->where('is_active', true)->first();
    }
}
