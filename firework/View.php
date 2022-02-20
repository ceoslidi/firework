<?php

namespace Firework;

use Exception;

class View {
    /**
     * @param string viewName
     * @param array varValues
     * @return void
     * @throws Exception
     */
    public function renderView(string $viewName, array $varValues): void
    {
        $fileName = $viewName . '.fire.php';
        $view = $this->getView($fileName);
        $matches = [];

        preg_match_all('/{{.*}}/i', $view, $matches);
        $matches = $matches[0];

        $data = [];

        for ($i = 0; $i < count($varValues); $i++)
        {
            $str = str_replace('{', '', $matches[$i]);
            $str = str_replace('}', '', $str);

            $data[$matches[$i]] = $varValues[$str];
        }

        foreach ($matches as $elem)
        {
            $str = $data[$elem];
            $view = str_replace($elem, $str, $view);
        }

        print_r($view);
    }

    /**
     * @param string fileName
     * @return string
     * @throws Exception
     */
    private function getView($fileName): string
    {
        $view = file_get_contents(urldecode(__DIR__ . '/../app/views/' . $fileName));

        if ($view === false)
            throw new Exception('Cannot reach the file you\' re looking for.');

        return $view;
    }
}