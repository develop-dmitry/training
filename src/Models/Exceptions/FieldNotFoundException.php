<?php

namespace App\Models\Exceptions;

use Exception;
use Throwable;

class FieldNotFoundException extends Exception
{

    public function __construct(string $message = "", int $code = 0, ?Throwable $previous = null)
    {
        $message = "Field `$message` not found in Model";

        parent::__construct($message, $code, $previous);
    }
}