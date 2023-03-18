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
    public function update(array $request)
    {
        $validatedData = new Validator($request);
        $validatedData->requiredField('title');
        $validatedData->requiredField('node_id');
        $validatedData->validateString('title', 5, 15);
        if (!empty($validatedData->getErrors())) {
            return response()->json(['errors' => $validatedData->getErrors()], 422);
        }
        $editNode = (new Node())->find($request['node_id']);
        if (is_null($editNode)) {
            return response()->json(['errors' => 'Node not found'], 423);
        }
        $prevTitle = $editNode['title'];
        $editNode = (new Node())->update(['id' => $editNode['id'], 'title' => $request['title']]);
        if (!$editNode) {
            return response()->json(['errors' => 'Failed to change node title from ' . $prevTitle . ' to ' . $request['title']], 423);
        }
        return response()->json(['data' => 'Title of node ' . $prevTitle . ' changed to ' . $request['title'] . ' successfully']);
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