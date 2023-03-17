<?php

use TestTaskSolidSolutions\app\controllers\HomeController;
use TestTaskSolidSolutions\Core\Router;
Router::get('/', [HomeController::class, 'index']);