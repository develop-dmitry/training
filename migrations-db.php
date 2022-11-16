<?php

use Symfony\Component\Dotenv\Dotenv;

require_once 'vendor/autoload.php';

$dotenv = new Dotenv();
$dotenv->load('.env');

return [
    'dbname' => $_ENV['DB_NAME'],
    'user' => $_ENV['DB_USERNAME'],
    'password' => $_ENV['DB_PASSWORD'],
    'host' => $_ENV['DB_HOST'],
    'driver' => 'pdo_mysql',
];