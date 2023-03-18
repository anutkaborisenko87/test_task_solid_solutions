<?php

namespace TestTaskSolidSolutions\Core;

use Exception;
use TestTaskSolidSolutions\Core\DataBase\QueryBuilder;

class Model
{
    protected $table;
    protected $fillable = [];
    protected $primaryKey = 'id';
    protected $queryBuilder;

    public function __construct()
    {
        $this->queryBuilder = new QueryBuilder();
        $this->queryBuilder->table($this->table);
    }
    public function __get($name) {
        if (in_array($name, $this->fillable)) {
            return $this->$name;
        } else {
            throw new Exception("Property $name does not exist.");
        }
    }

    public function __set($name, $value) {
        if (in_array($name, $this->fillable)) {
            $this->$name = $value;
        } else {
            throw new Exception("Property $name does not exist.");
        }
    }

    public function create(array $data)
    {
        return (new QueryBuilder())->table($this->table)->insert($data);
    }

    public function update($data): int
    {
        $id = $data[$this->primaryKey];
        $columns = array_intersect_key($data, array_flip($this->fillable));
        unset($columns[$this->primaryKey]);
        return (new QueryBuilder())->table($this->table)->where($this->primaryKey, '=', $id)->update($columns);
    }

    public function delete($id): int
    {
        return $this->queryBuilder->where($this->primaryKey, '=', $id)->delete();
    }

    public function find($id)
    {
        $this->queryBuilder->where($this->primaryKey, '=', $id);
        return $this->queryBuilder->get()[0];
    }

    public function all()
    {
        return $this->queryBuilder->get();
    }

    public function where(string $column, string $operator, $value)
    {
        $this->queryBuilder->where($column, $operator, $value);
        return $this->queryBuilder->get();
    }

}