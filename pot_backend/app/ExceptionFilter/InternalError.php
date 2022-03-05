<?php

namespace App\ExceptionFilter;

use Closure;

class InternalError {
    use Helper;

    public function handle($response, Closure $next)
    {
        if ($response->exception instanceof \Exception) {
            return response()->json([
                'status' => 'error',
                'message' => 'InternalError: ' . $response->exception->getMessage(),
            ], $this->statusCodeHandler($response->exception, 500));
        }

        return $next($response);
    }
}