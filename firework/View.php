<?php

namespace Firework;

class View {
    /**
      * @param string $view_name
      * @param object $var_values
      * @return string
     */
    public function render(string $view_name, object $var_values): string
    {
        $filename = $view_name . '.firework.php';
        $view = $this->get_view($filename, $var_values);

        if ($view === false)
            return false;

        preg_match_all('/{{.*}}/i', $view, $matches);
        foreach ($matches as $elem)
        {
            preg_replace('{{' . $elem . '}}', $var_values->$elem, $view);
        }
        return $view;
    }

    /**
     * @param string filename
     * @return string
     */
    private function get_view($filename): string
    {
        $view = file_get_contents(urldecode('./app/views/' . $filename));

        if ($view === false)
            return false;

        return $view;

    }
}