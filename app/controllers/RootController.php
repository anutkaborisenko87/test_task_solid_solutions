<?php

namespace TestTaskSolidSolutions\app\controllers;

use TestTaskSolidSolutions\app\models\Node;
use TestTaskSolidSolutions\app\models\Root;
use TestTaskSolidSolutions\Core\Response;
use TestTaskSolidSolutions\Core\Validator;

class RootController
{
    /**
     * @return Response
     */
    public function index(): Response
    {
        $roots = (new Root())->roots();
        $trees = [];
        foreach ($roots as $root) {
            $nodes = (new Node())->getAllNodes($root['id']);
            $root['nodes'] = $nodes;
            $trees[] = $root;
        }
        return response()->json(['data' => $trees]);
    }

    /**
     * @param array $request
     * @return Response
     */
    public function create(array $request): Response
    {
        $validatedData = new Validator($request);
        $validatedData->requiredField('title');
        $validatedData->validateString('title', 5, 15);
        if (!empty($validatedData->getErrors())) {
            return response()->json(['errors' => $validatedData->getErrors()], 422);
        }

        $root = (new Root())->create(['title' => $request['title']]);
        if (!is_null($root)) {
            return response()->json(['data' => 'Root ' . $request['title'] . ' created successfully'], 200);
        }
        return response()->json(['errors' => 'Something went wrong'], 422);
    }

    /**
     * @param array $request
     * @return Response
     */

    public function delete(array $request): Response
    {
        $deletingRoot = (new Root())->find($request['root_id']);
        if (empty($deletingRoot)) {
            return response()->json(['errors' => 'Root not found'], 404);
        }
        $deletedRoot = (new Root())->delete($request['root_id']);
        if ($deletedRoot === 0) {
            return response()->json(['errors' => 'Something went wrong'], 422);
        }
        return response()->json(['data' => 'Root ' . $deletingRoot['title'] . ' deleted']);
    }

}