<?php

namespace App\Http\Controllers;

use App\Models\RequestAttachment;
use App\Models\RequestResultAttachment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class StorageController extends Controller
{
    //

    public function getRequestAttachment(RequestAttachment $requestAttachment)
    {
        if (!Storage::exists($requestAttachment->url)) {
            abort(404, 'File not found');
        } else {
            $filePath = Storage::disk('local')->path($requestAttachment->url);
            return response()->file($filePath);
        }
    }

    public function getRequestResultAttachment(RequestResultAttachment $requestResultAttachment)
    {
        if (!Storage::exists($requestResultAttachment->url)) {
            abort(404, 'File not found');
        } else {
            $filePath = Storage::disk('local')->path($requestResultAttachment->url);
            return response()->file($filePath);
        }
    }
}
