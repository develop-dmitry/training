<?php

use App\Core\DataBase\Connection;
use PHPUnit\Framework\TestCase;

final class DataBaseTest extends TestCase
{
    public function testConnection(): void
    {
        $this->assertNotNull(Connection::getConnection());
    }
}