<?php

namespace App\Core;

use App\Traits\Singleton;
use Symfony\Component\Dotenv\Dotenv;

class Config
{
    use Singleton;

    protected Dotenv $dotenv;

    protected string $rootDirectory = '/var/www/html';

    protected array $config = [];

    private function __construct()
    {
        $this->dotenv = new Dotenv();
        $this->dotenv->load($this->getRootDirectory() . '/.env');

        $this->config = array_merge($this->config, $_ENV);
    }

    public function getRootDirectory(): string
    {
        return $this->rootDirectory;
    }

    public function __get(string $name)
    {
        return $this->config[$name] ?? false;
    }
}