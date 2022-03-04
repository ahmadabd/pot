<?php

namespace App\ExceptionFilter;

use Closure;
use Illuminate\Auth\Access\AuthorizationException;

class UnAuthorized 
{
    use Helper;

    public function handle($response, Closure $next)
    {
        if (!empty($response->exception) && $response->exception instanceof AuthorizationException) {
            return response()->json([
                'status' => 'error',
                'message' => 'UnAuthorized: ' . $response->exception->getMessage(),
            ], $this->statusCodeHandler($response->exception, 401));
        }

        return $next($response);
    }
}