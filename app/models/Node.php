<?php
namespace TestTaskSolidSolutions\app\models;
use http\QueryString;
use TestTaskSolidSolutions\Core\DataBase\QueryBuilder;
use TestTaskSolidSolutions\Core\Model;

class Node extends Model
{
    protected $table = 'nodes';
    protected $primaryKey = 'id';
    protected $fillable = [
      'id',
      'title',
      'parent_id'
    ];

    public function nodes($id): array
    {
        return (new QueryBuilder())->table($this->table)->where('parent_id', '=', $id)->get();
    }

    public function getAllNodes($id, $depth = 0): array
    {
        $nodes = $this->nodes($id);
        $result = [];
        foreach ($nodes as $node) {
            $node['depth'] = $depth;
            $node['nodes'] = $this->getAllNodes($node['id'], $depth + 1);
            $result[] = $node;
        }

        return $result;
    }

}