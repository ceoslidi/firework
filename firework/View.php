<?php

namespace Firework;

class View {
    /**
     * @param string viewName
     * @param object varValues
     * @return string
     * @throws \Exception
     */
    public function renderView(string $viewName, object $varValues): string
    {
        $fileName = $viewName . '.firework.php';
        $view = $this->getView($fileName, $varValues);

        preg_match_all('/{{.*}}/i', $view, $matches);
        foreach ($matches as $elem)
        {
            preg_replace('{{' . $elem . '}}', $varValues->$elem, $view);
        }
        return $view;
    }

    /**
     * @param string fileName
     * @return string
     * @throws \Exception
     */
    private function getView($fileName): string
    {
        $view = file_get_contents(urldecode('./app/views/' . $fileName));

        if ($view === false)
            throw new \Exception('Cannot reach the file you\' re looking for.');

        return $view;
    }
}