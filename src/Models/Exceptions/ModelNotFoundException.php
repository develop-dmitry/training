<?php

namespace App\Models\Exceptions;

use Exception;
use Throwable;

class ModelNotFoundException extends Exception
{

    public function __construct(string $message = "", int $code = 0, ?Throwable $previous = null)
    {
        $message = $message ?? 'Model not found';

        parent::__construct($message, $code, $previous);
    }
}