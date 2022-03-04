<?php

namespace App\ExceptionFilter;

use Exception;

trait Helper {
    public function statusCodeHandler(Exception $exception, int $statusCode) : int
    {
        return empty($exception->getCode()) ? $statusCode : $exception->getCode();       
    }
}