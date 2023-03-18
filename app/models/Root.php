<?php

namespace TestTaskSolidSolutions\app\models;

use TestTaskSolidSolutions\Core\Model;

class Root extends Model
{
    protected $table = 'nodes';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id',
        'title',
        'parent_id'
    ];

    public function roots()
    {
        return $this->queryBuilder->whereNull('parent_id');
    }
}