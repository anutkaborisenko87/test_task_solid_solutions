<?php

namespace TestTaskSolidSolutions\app\controllers;

use TestTaskSolidSolutions\app\models\Node;
use TestTaskSolidSolutions\Core\Validator;

class NodeController
{
    public function create($request)
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
            $dataToResponse = (new Node())->find($node);
            $dataToResponse['nodes'] = (new Node())->getAllNodes($dataToResponse['id']);
            return response()->json(['data' => $dataToResponse], 200);
        }

    }

}