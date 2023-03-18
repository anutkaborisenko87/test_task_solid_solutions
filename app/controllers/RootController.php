<?php

namespace TestTaskSolidSolutions\app\controllers;

use TestTaskSolidSolutions\app\models\Node;
use TestTaskSolidSolutions\app\models\Root;
use TestTaskSolidSolutions\Core\DataBase\QueryBuilder;
use TestTaskSolidSolutions\Core\Response;
use TestTaskSolidSolutions\Core\Validator;

class RootController
{
    /**
     * @param $request
     * @return Response
     */
        public function create($request): Response
        {
            $validatedData = new Validator($request);
            $validatedData->requiredField('title');
            $validatedData->validateString('title', 5, 15);
            if (!empty($validatedData->getErrors())) {
                return response()->json(['errors' => $validatedData->getErrors()], 422);
            }

            $root = (new Root())->create(['title' => $request['title']]);
            if (!is_null($root)) {
                $dataToResponse = (new Root())->find($root);
                $dataToResponse['nodes'] = (new Node())->getAllNodes($dataToResponse['id']);
                return response()->json(['data' => $dataToResponse], 200);
            }
            return response()->json(['errors' => 'Something went wrong'], 422);
        }

        public function delete($request)
        {
            $deletedRoot = (new Root())->delete($request['root_id']);
            if ($deletedRoot === 0) {
                return response()->json(['errors' => 'Something went wrong'], 422);
            }
            return response()->json(['message' => 'Root' . $request['root_id'] . 'deleted', 'root_id'=> $request['root_id']]);
        }

}