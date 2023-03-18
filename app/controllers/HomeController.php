<?php

namespace TestTaskSolidSolutions\app\controllers;


use TestTaskSolidSolutions\app\models\Node;
use TestTaskSolidSolutions\app\models\Root;
use TestTaskSolidSolutions\Core\Controller;

class HomeController extends Controller
{
    /**
     * @return void
     */
    public function index()
    {
        $roots = (new Root())->roots();
        $trees = [];
        foreach ($roots as $root) {
            $nodes = (new Node())->getAllNodes($root['id']);
            $root['nodes'] = $nodes;
            $trees[] = $root;
        }
        $contentdata = $trees;
        $data = [
            'title' => 'Home Page',
            'site_name' => 'Anna Borisenko Test task',
            'contentdata' => $contentdata
        ];
        $this->view->render('home', $data);
    }
}