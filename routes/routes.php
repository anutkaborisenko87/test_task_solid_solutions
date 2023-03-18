<?php

use TestTaskSolidSolutions\app\controllers\HomeController;
use TestTaskSolidSolutions\app\controllers\NodeController;
use TestTaskSolidSolutions\app\controllers\RootController;
use TestTaskSolidSolutions\Core\Router;

Router::get('/', [HomeController::class, 'index']);
Router::get('/get_roots', [RootController::class, 'index']);
Router::post('/new_root', [RootController::class, 'create']);
Router::post('/new_node', [NodeController::class, 'create']);
Router::put('/edit_node', [NodeController::class, 'update']);
Router::delete('/delete_root', [RootController::class, 'delete']);
Router::delete('/delete_node', [NodeController::class, 'delete']);