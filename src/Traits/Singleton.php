<?php

namespace App\Traits;

trait Singleton
{

    protected static ?self $instance = null;

    public static function getInstance(): self
    {
        if (!static::$instance) {
            static::$instance = new self();
        }

        return static::$instance;
    }
}