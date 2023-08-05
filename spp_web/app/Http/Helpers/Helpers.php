<?php

use App\Models\Period;

if (!function_exists('getCurrentPeriod')) {
    function getCurrentPeriod(): ?Period
    {
        return Period::query()->where('is_active', true)->first();
    }
}

if (!function_exists('getArchivePeriod')) {
    function getArchivePeriod(): ?Period
    {
        return Period::query()->where('is_active', false)->first();
    }
}

if (!function_exists('getArchivePeriods')) {
    function getArchivePeriods(): ?Period
    {
        return Period::query()->where('is_active', false)->first();
    }
}

if (!function_exists('getCurrentPeriodId')) {
    function getCurrentPeriodId(): ?int
    {
        $period = getCurrentPeriod();
        return $period ? $period->id : '';
    }
}

if (!function_exists('activePeriodIsExists')) {
    function activePeriodIsExists(): ?int
    {
        $period = Period::query()->where('is_active', true)->exists();
        return $period ? true : false;
    }
}

if (!function_exists('archivePeriodIsExists')) {
    function archivePeriodIsExists(): ?int
    {
        $period = Period::query()->where('is_active', false)->exists();
        return $period && activePeriodIsExists() ? true : false;
    }
}
