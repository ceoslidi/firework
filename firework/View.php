<?php

namespace Firework;

use Exception;

/*
 Class that controls view interactions.
 Includes:
  public renderView method,
  private getView method,
  private parseViewLoops method,
  private parseViewConds method.
 */
class View {
    /*
     Renders and returns code of view with defined name.
     */
    /**
     * @param string $viewName
     * @param array $varValues
     * @return void
     * @throws Exception
     */
    public function renderView(string $viewName, array $varValues): void
    {
        $fileName = $viewName . '.fire.php';
        $view = $this->getView($fileName);
        $matches = [];

//       Matches all in-view vars.
        preg_match_all('/{{.*}}/i', $view, $matches);
        $matches = $matches[0];

        $data = [];

        for ($i = 0; $i < count($varValues); $i++)
        {
            $str = str_replace('{', '', $matches[$i]);
            $str = str_replace('}', '', $str);

            $data[$matches[$i]] = $varValues[$str];
        }

        $view = $this->parseViewLoops($view);
        $view = $this->parseViewConds($view, $varValues);

        if (!$view) throw new Exception('Something went wrong in rendering your view');

        foreach ($matches as $elem)
        {
            $str = $data[$elem];
            $view = str_replace($elem, $str, $view);
        }

        print_r($view);
    }

    /*
     Function gets the code of view with defined name from the app dir.
     */
    /**
     * @param string $fileName
     * @return string
     * @throws Exception
     */
    private function getView(string $fileName): string
    {
        $view = file_get_contents(urldecode(__DIR__ . '/../app/views/' . $fileName));

        if ($view === false)
            throw new Exception('Cannot reach the file you\' re looking for.');

        return $view;
    }

    /*
     Parses all loops in view and changes them with their content.
     */
    /**
     * @param string $view
     * @return string|bool
     */
    private function parseViewLoops(string $view): bool|string
    {
        $res = '';

//       Changes the @foreach construction with inbuilt php loop.
        $view = str_replace('@foreach', 'foreach', $view);

        preg_replace('/{/m', '{ $res . "', $view);
        preg_replace('/}/m', '"}', $view);
        eval($view);
//       TODO: remove the eval() to improve safety.

        if (!$res) return false;

        return $res;
    }


    /*
      Parses all conditions in view and changes them with their content matching the condition.
     */
    /**
     * @param $view
     * @param $varValues
     * @return bool|string
     * @throws Exception
     */
    private function parseViewConds($view, $varValues): bool|string
    {
        $res = '';
//        Replaces @if, @elif and @else constructions with inbuilt analogues.
        $view = str_replace('@if', 'if', $view);
        $view = str_replace('@elseif', 'elseif', $view);
        $view = str_replace('@else', 'else', $view);
        preg_replace('/{/m', '{ $res . "', $view);
        preg_replace('/}/m', '"}', $view);

//       Matches all possible variable names.
        preg_match_all('/[a-zA-Z_\x80-\xff][a-zA-Z0-9_\x80-\xff]*/m', $view, $vars);
        $vars = $vars[0];

        foreach($vars as $var)
        {
            if (!isset($varValues[$var])) throw new Exception('Trying to get value of an undefined variable.');
            str_replace($var, $varValues[$var], $view);
        }

        eval($view);
//       TODO: remove the eval() to improve safety.

        if (!$res) return false;

        return $res;
    }
}