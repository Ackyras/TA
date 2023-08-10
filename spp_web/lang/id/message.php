<?php

$models = __('model');

$events = __('event');

$messages = [];

foreach ($models as $modelKey => $modelValue) {
    foreach ($events as $eventKey => $eventValue) {
        $messages[$modelKey][$eventKey] = __('event.' . $eventKey, ['model' => $modelValue]);
    }
}

$status = __('status');

$messages['validation'] =
    [
        'error'     =>  'Data yang dimasukkan tidak valid'
    ];

return $messages;
