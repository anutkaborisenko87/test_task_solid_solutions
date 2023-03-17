<?php

namespace TestTaskSolidSolutions\app\controllers;


use TestTaskSolidSolutions\app\models\Node;
use TestTaskSolidSolutions\Core\Controller;

class HomeController extends Controller
{
    public function index()
    {
        $roots = (new Node())->roots();
        $trees = [];
        foreach ($roots as $root) {
            $nodes = (new Node())->nodes($root['id']);

            $root['nodes'] = $nodes;
            $trees[] = $root;
        }
        dd($trees);
        $contentdata = 'hello';
        $data = [
            'title' => 'Home Page',
            'site_name' => 'My Website',
            'contentdata' => $contentdata
        ];
        return $this->view->render('home', $data);
    }

}