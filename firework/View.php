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

        /*
        $view = $this->parseLoops($view);
        $view = $this->parseConds($view, $varValues);
        */

        if (!$view) throw new Exception('Something went wrong in rendering your view');

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


    /**
     * @param string $view
     * @return string|bool
     */
    private function parseLoops(string $view): string|bool
    {
        $res = '';
        $view = str_replace('@foreach', 'foreach', $view);
        preg_replace('/{/m', '{ $res . "', $view);
        preg_replace('/}/m', '"}', $view);
        eval($view);
//            TODO: remove the eval() to improve safety

        if (!$res) return false;

        return $res;
    }

    /**
     * @param $view
     * @param $varValues
     * @return bool|string
     * @throws Exception
     */
    private function parseConds($view, $varValues): bool|string
    {
        $res = '';
        $view = str_replace('@if', 'if', $view);
        $view = str_replace('@elseif', 'elseif', $view);
        $view = str_replace('@else', 'else', $view);
        preg_replace('/{/m', '{ $res . "', $view);
        preg_replace('/}/m', '"}', $view);
        preg_match_all('/[a-zA-Z_\x80-\xff][a-zA-Z0-9_\x80-\xff]*/m', $view, $vars);
        $vars = $vars[0];

        foreach($vars as $var)
        {
            if (!isset($varValues[$var])) throw new Exception('Trying to get value of an undefined variable.');
            str_replace($var, $varValues[$var], $view);
        }

        eval($view);
//            TODO: remove the eval() to improve safety

        if (!$res) return false;

        return $res;
    }
}