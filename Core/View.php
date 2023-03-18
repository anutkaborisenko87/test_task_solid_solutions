<?php

namespace TestTaskSolidSolutions\Core;

class View
{
    /**
     * @var string
     */
    protected $layout = 'app';

    /**
     * @param $view
     * @param $data
     * @return void
     */
    public function render($view, $data = [])
    {
        $layout = $this->getLayout($data);
        $content = $this->getContent($view, $data);
        $output = str_replace('{{ content }}', $content, $layout);

        echo $output;
    }

    /**
     * @param string $view
     * @param array $data
     * @return false|string
     */

    public function getContent(string $view, array $data = [])
    {
        extract($data);
        ob_start();
        if (file_exists(ROOT . '/src/views/' . $view . '.php')) {
            require_once ROOT . '/src/views/' . $view . '.php';
        }
        return ob_get_clean();
    }

    /**
     * @param array $data
     * @return false|string
     */
    public function getLayout(array $data = [])
    {
        extract($data);
        ob_start();

        if (file_exists(ROOT . '/src/layouts/' . $this->layout . '.php')) {
            require_once ROOT . '/src/layouts/' . $this->layout . '.php';
        }

        return ob_get_clean();
    }

    /**
     * @param $layout
     * @return void
     */
    public function setLayout($layout)
    {
        $this->layout = $layout;
    }
}