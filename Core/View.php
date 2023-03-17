<?php

namespace TestTaskSolidSolutions\Core;

class View
{
    protected $layout = 'app';

    public function render($view, $data = [])
    {
        $layout = $this->getLayout($data);
        $content = $this->getContent($view, $data);
        $output = str_replace('{{ content }}', $content, $layout);

        echo $output;
    }

    public function getContent($view, $data = [])
    {
        extract($data);
        ob_start();
        if (file_exists(ROOT . '/src/views/' . $view . '.php')) {
            require_once ROOT . '/src/views/' . $view . '.php';
        }
        return ob_get_clean();
    }

    public function getLayout($data = [])
    {
        extract($data);
        ob_start();

        if (file_exists(ROOT . '/src/layouts/' . $this->layout . '.php')) {
            require_once ROOT . '/src/layouts/' . $this->layout . '.php';
        }

        return ob_get_clean();
    }

    public function setLayout($layout)
    {
        $this->layout = $layout;
    }
}