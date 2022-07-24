<?php

namespace App\Exceptions;

use Exception;

class UnsecureException extends Exception
{
    /**
     * Render the exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request
     *
     * @return \Illuminate\Http\Response
     */
    public function render($request)
    {
        return response()->json([
            'error' => '404',
            'message' => $this->getMessage(),
        ], 404);
    }
}