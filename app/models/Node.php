<?php
namespace TestTaskSolidSolutions\app\models;
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

    public function roots()
    {
        return $this->queryBuilder->whereNull('parent_id');
    }

    public function nodes($id)
    {
        $nodes = $this->queryBuilder->where('parent_id', '=', $id)->get();
        foreach ($nodes as $node) {
            $childNodes = $this->queryBuilder->where('parent_id', '=', $node['id'])->get();
            $node['children'] = $childNodes;
            foreach ($childNodes as $childNode) {
                $grandChildNodes = $this->queryBuilder->where('parent_id', '=', $childNode['id'])->get();
                $childNode['children'] = $grandChildNodes;
            }
        }
        return $nodes;
    }


}