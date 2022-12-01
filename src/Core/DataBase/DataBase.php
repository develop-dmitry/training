<?php

namespace App\Core\DataBase;

use App\Traits\Singleton;
use Exception;
use PDO;
use PDOStatement;

class DataBase
{
    use Singleton;

    protected PDO $connection;

    private function __construct()
    {
        $this->connection = Connection::getConnection();
    }

    public function query(string $query, array $data = []): PDOStatement
    {
        $statement = $this->connection->prepare($query);

        $statement->execute($data);

        return $statement;
    }

    public function select(string $query, array $data = []): Result
    {
        try {
            $statement = $this->query($query, $data);

            return Result::make($statement->fetchAll(PDO::FETCH_ASSOC));
        } catch (Exception $exception) {
            return Result::make()->withSuccess(false);
        }
    }

    public function insert(string $query, array $data = []): Result
    {
        try {
            $this->query($query, $data);

            return Result::make($this->connection->lastInsertId());
        } catch (Exception $exception) {
            return Result::make()->withSuccess(false);
        }
    }

    public function update(string $query, array $data = []): Result
    {
        try {
            $this->query($query, $data);

            return Result::make();
        } catch (Exception $exception) {
            return Result::make()->withSuccess(false);
        }
    }

    public function delete(string $query, array $data = []): Result
    {
        try {
            $statement = $this->query($query, $data);

            return Result::make($statement);
        } catch (Exception $exception) {
            return Result::make()->withSuccess(false);
        }
    }
}