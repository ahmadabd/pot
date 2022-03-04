<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Pipeline\Pipeline;

class checkExceptionApi
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);
    
        $response = app(Pipeline::class)->send($response)->through([
            \App\ExceptionFilter\UnAuthorized::class,
            \App\ExceptionFilter\ModelNotFound::class,
            \App\ExceptionFilter\InternalError::class,
        ])->thenReturn();

        return $response;
    }
}
