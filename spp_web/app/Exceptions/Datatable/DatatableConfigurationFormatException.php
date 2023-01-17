<?php

namespace App\Exceptions\Datatable;

use Exception;

class DatatableConfigurationFormatException extends Exception
{
    //
    /**
     * Generating report when exception found
     *
     * @param  mixed $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render the error message
     *
     * @param  mixed $request
     * @param  mixed $exception
     * @return void
     */
    public function render($request)
    {
        if ($request->is('api/*')) {
            return response()->json(
                [
                    'message'   =>  `Configuration didn't meet requirement.`
                ],
            );
        } else {
            return abort(500);
        }
    }
}
