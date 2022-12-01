<?php

namespace App\Core\DataBase;

class Result
{

    protected bool $success;

    protected mixed $result;

    protected function __construct(mixed $result)
    {
        $this->success = true;
        $this->result = $result;
    }

    public function success(): bool
    {
        return $this->success;
    }

    public function result(): mixed
    {
        return $this->result;
    }

    public static function make(mixed $result = ''): Result
    {
        return new Result($result);
    }

    public function withSuccess(bool $success): Result
    {
        $this->success = $success;

        return $this;
    }
}