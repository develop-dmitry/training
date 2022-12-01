<?php

namespace App\Models;

use App\Core\DataBase\DataBase;
use App\Models\Exceptions\FieldNotFoundException;
use App\Models\Exceptions\ModelNotFoundException;

abstract class Model
{

    protected static string $table = '';

    protected static string $primary = 'id';

    protected static array $fields = [];

    protected static array $fillable = [];

    protected static string $createdAt = 'created_at';

    protected static string $updatedAt = 'updated_at';

    protected array $data;

    protected DataBase $db;

    public function __construct()
    {
        $this->db = DataBase::getInstance();
        $this->data = [];

        $this->fill();
    }

    public static function find(string $primary): static
    {
        try {
            return static::findOrFail($primary);
        } catch (ModelNotFoundException) {
            return new static();
        }
    }

    /**
     * @throws ModelNotFoundException
     */
    public static function findOrFail(string $primary): static
    {
        $model = new static();

        $query = 'SELECT * FROM ' . static::$table . ' WHERE ' . static::$primary . '= :primary';

        $response = $model->db->select($query, [
            'primary' => $primary
        ]);

        if (!$response->success() || empty($response->result())) {
            throw new ModelNotFoundException();
        }

        $model->fill($response->result()[0]);
        $model->setPrimary($response->result()[0][static::$primary]);

        return $model;
    }

    /**
     * @throws FieldNotFoundException
     */
    public function __get(string $name)
    {
        if (!in_array($name, static::$fields)) {
            throw new FieldNotFoundException($name);
        }

        return $this->data[$name];
    }

    /**
     * @throws FieldNotFoundException
     */
    public function __set(string $name, $value): void
    {
        if (!in_array($name, static::$fields)) {
            throw new FieldNotFoundException($name);
        }

        $this->data[$name] = $value;
    }

    public function save(): bool
    {
        if ($this->exists()) {
            return $this->update();
        }

        return $this->create();
    }

    public function destroy(): bool
    {
        if (!$this->exists()) {
            return false;
        }

        $sql = 'DELETE FROM ' . static::$table . ' WHERE ' . static::$primary . ' = :' . static::$primary;

        $response = $this->db->delete($sql, [
            static::$primary => $this->data[static::$primary]
        ]);

        if ($response->success()) {
            $this->data = [];
        }

        return $response->success();
    }

    public function exists(): bool
    {
        return !empty($this->data[static::$primary]);
    }

    public function fill(array $data = []): void
    {
        foreach (static::$fields as $field) {
            if ($field === static::$primary) {
                continue;
            }

            $this->data[$field] = $data[$field] ?? '';
        }
    }

    public static function fromArray(array $data): static
    {
        $model = new static();

        $model->fill($data);

        return $model;
    }

    protected function create(): bool
    {
        $values = $this->preparedData();

        $names = implode(',', array_keys($values));

        $params = array_keys($values);

        array_walk($params, function (&$item) {
            $item = ":$item";
        });

        $params = implode(',', $params);

        $sql = 'INSERT INTO ' . static::$table . '(' . $names . ') VALUES (' . $params . ')';

        $response = $this->db->insert($sql, $values);

        if ($response->success()) {
            $this->fill($values);
            $this->setPrimary($response->result());
        }

        return $response->success();
    }

    protected function update(): bool
    {
        if (!$this->exists()) {
            return false;
        }

        $data = $this->preparedData();

        $sql = 'UPDATE ' . static::$table . ' SET ';

        $values = [];

        foreach ($data as $key => $value) {
            $values[] = $key . ' = :' . $key;
        }

        $sql .= implode(',', $values) . ' WHERE ' . static::$primary . '= :' . static::$primary;

        $data[static::$primary] = $this->primary();

        return $this->db->update($sql, $data)->success();
    }

    protected function preparedData(): array
    {
        $data = array_filter($this->data, function ($item, $key) {
            return in_array($key, static::$fillable);
        }, ARRAY_FILTER_USE_BOTH);

        if (!empty(static::$createdAt) && empty($this->data[static::$createdAt])) {
            $data[static::$createdAt] = date('Y-m-d H:i:s');
        }

        if (!empty(static::$updatedAt)) {
            $data[static::$updatedAt] = date('Y-m-d H:i:s');
        }

        return $data;
    }

    protected function setPrimary(mixed $value): void
    {
        $this->data[static::$primary] = $value;
    }

    protected function primary(): mixed
    {
        return $this->data[static::$primary];
    }
}