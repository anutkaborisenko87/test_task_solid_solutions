<?php

namespace TestTaskSolidSolutions\Core;

use Exception;
use TestTaskSolidSolutions\Core\DataBase\QueryBuilder;

class Model
{
    /**
     * @var string
     */
    protected $table;
    /**
     * @var array
     */
    protected $fillable = [];
    /**
     * @var string
     */
    protected $primaryKey = 'id';
    /**
     * @var QueryBuilder
     */
    protected $queryBuilder;

    public function __construct()
    {
        $this->queryBuilder = new QueryBuilder();
        $this->queryBuilder->table($this->table);
    }

    /**
     * @param array $data
     * @return false|string
     */
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

    /**
     * @param $id
     * @return int
     */
    public function delete($id): int
    {
        return $this->queryBuilder->where($this->primaryKey, '=', $id)->delete();
    }

    /**
     * @param $id
     * @return mixed
     */
    public function find($id)
    {
        $this->queryBuilder->where($this->primaryKey, '=', $id);
        return $this->queryBuilder->get()[0];
    }

}