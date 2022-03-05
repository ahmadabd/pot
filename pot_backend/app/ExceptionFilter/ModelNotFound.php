<?php

namespace App\ExceptionFilter;

use Closure;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ModelNotFound 
{
    use Helper;

    public function handle($response, Closure $next)
    {
        if ($response->exception instanceof ModelNotFoundException) {
            return response()->json([
                'status' => 'error',
                'message' => 'ModelNotFound: ' . $response->exception->getMessage(),
            ], $this->statusCodeHandler($response->exception, 404));
        }

        return $next($response);
    }    
}