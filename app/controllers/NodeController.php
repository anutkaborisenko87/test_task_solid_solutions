<?php

namespace TestTaskSolidSolutions\app\controllers;

use TestTaskSolidSolutions\app\models\Node;
use TestTaskSolidSolutions\Core\Response;
use TestTaskSolidSolutions\Core\Validator;

class NodeController
{
    /**
     * @param array $request
     * @return Response
     */
    public function create(array $request): Response
    {
        $validatedData = new Validator($request);
        $validatedData->requiredField('title');
        $validatedData->requiredField('parent_id');
        $validatedData->validateString('title', 5, 15);
        if (!empty($validatedData->getErrors())) {
            return response()->json(['errors' => $validatedData->getErrors()], 422);
        }
        $parentNode = (new Node())->find($request['parent_id']);

        if (is_null($parentNode)) {
            return response()->json(['errors' => 'prent node not found'], 423);
        }
        $node = (new Node())->create([
                'title' => $request['title'],
                'parent_id' => $request['parent_id']
            ]);
        if (!is_null($node)) {
            return response()->json(['data' => 'Node ' . $request['title'] . ' created successfully']);
        }
        return response()->json(['errors' => 'Something went wrong'], 422);

    }

    /**
     * @param array $request
     * @return Response
     */
    public function delete(array $request): Response
    {
        $deletingNode = (new Node())->find($request['node_id']);
        if (empty($deletingNode)) {
            return response()->json(['errors' => 'Node not found'], 404);
        }
        $deletedNode = (new Node())->delete($request['node_id']);
        if ($deletedNode === 0) {
            return response()->json(['errors' => 'Something went wrong'], 422);
        }
        return response()->json(['data' => 'Node ' . $deletingNode['title'] . ' deleted']);
    }

}