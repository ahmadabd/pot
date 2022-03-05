<?php

namespace App\ExceptionFilter;

use Closure;
use Illuminate\Validation\ValidationException;

class Validation 
{
    use Helper;

    public function handle($response, Closure $next)
    {
        if ($response->exception instanceof ValidationException) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation: ' . $response->exception->getMessage()
            ], $this->statusCodeHandler($response->exception, 400));
        }
    }
}