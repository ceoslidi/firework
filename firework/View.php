<?php

namespace Firework;

use Firework\Csrf;

use Exception;

/*
 * Class that controls view interactions.
 * Includes:
 *  public renderView method,
 *  private getView method,
 *  private parseViewLoops method,
 *  private parseViewConds method.
 */
class View {
    /*
     * Renders and returns code of view with defined name.
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
        $view = $this->getView('view', $fileName);
        $matches = [];

//       Matches all in-view vars.
        preg_match_all('/{{.+}}/s', $view, $matches);
        $matches = $matches[0];

        $data = [];

        for ($i = 0; $i < count($varValues); $i++)
        {
            $str = str_replace('{', '', $matches[$i]);
            $str = str_replace('}', '', $str);

            $data[$matches[$i]] = $varValues[$str];
        }

        $view = $this->parseViewExtends($view, $varValues);
        $view = $this->parseViewConds($view, $varValues);
        $view = $this->parseViewLoops($view, $varValues);


        if (!$view) throw new Exception('Error: something went wrong in rendering your view.');

        foreach ($matches as $elem)
        {
            $str = $data[$elem];
            $view = str_replace($elem, $str, $view);
        }

        print_r(htmlspecialchars_decode($view));
    }

    /*
     * Function gets the code of view with defined name from the app dir.
     */
    /**
     * @param string $fileType
     * @param string $fileName
     * @return string
     * @throws Exception
     */
    private function getView(string $fileType, string $fileName): string
    {
        switch ($fileType) {
            case 'view':
                $view = file_get_contents(urldecode(__DIR__ . '/../app/views/' . $fileName));
            case 'extend':
                $view = file_get_contents(urldecode(__DIR__ . '/../app/views/extends' . $fileName));
            default:
                throw new Exception('Error: undefined view type.');
        }


        if ($view === false)
            throw new Exception('Error: cannot reach the file you\' re looking for.');

        return htmlspecialchars($view);
    }

    /*
     * Parses all loops in view and changes them with their content.
     */
    /**
     * @param string $view
     * @param array $varValues
     * @return string
     * @throws Exception
     */
    private function parseViewLoops(string $view, array $varValues): string
    {
//         TODO: add @for, @while, @do ... @while
        preg_match_all(
            '/@foreach\s*?' // Matches start of loop, '@foreach'.
                .'\(\s*?\$[a-zA-Z_\x80-\xff][a-zA-Z0-9_\x80-\xff]*\s+?' // Var with any possible name,
                                                                        // bracket and whitespaces, '($var'
                .'as\s+?' // 'as'.
                .'\$[a-zA-Z_\x80-\xff][a-zA-Z0-9_\x80-\xff]*?\s*?\)' // Second var, '$var)'.
                .'.+?' // Any code inside.
                .'@endforeach/s', // End of loop '@endforeach'.
            $view,
            $loops);

        $loops = $loops[0];

        if (count($loops) === 0)
            return $view;

        foreach($loops as $loop) {
            $res = '';

//             First $var (before 'as').
            preg_match('/(.+?)as/s', $loop, $subject);
            $subject = trim(preg_replace('/@foreach\s*\(\$/s', '', $subject[1], 1));

//            Second $var (after 'as').
            preg_match('/(as.+?)\)/s', $loop, $var);
            $var = trim(preg_replace('/as\s+\$/s', '', $var[1], 1));

//            Looped code.
            preg_match('/\).*?@endforeach/s', $loop, $code);
            $code = trim(preg_replace('\(/s', '', $code[0], 1));
            $code = trim(preg_replace('/\s*@endforeach/s', '', $code, 1));

            if (!isset($varValues[$subject]))
                throw new Exception('Error: trying to iterate an unknown variable.');

            $subject = $varValues[$subject];

            foreach ($subject as $s) {
                $res = $res . str_replace('$' . $var, $s, $code);
            }

            str_replace($loop, $res, $view);
        }

        return $this->parseViewLoops($view, $varValues);
    }

    /*
     * Parses all conditions in view and changes them with their content matching the condition.
     */
    /**
     * @param $view
     * @param $varValues
     * @return string
     * @throws Exception
     */
    private function parseViewConds($view, $varValues): string
    {
        $res = '';
        preg_match_all('/@if\s*\(.+\).+?@endif/s', $view, $condBlocks);

        if (!$condBlocks)
            return $view;

        foreach ($condBlocks as $condBlock)
        {
            preg_match_all('/\(.+/\)/', $condBlock, $conds);

            foreach ($conds as $cond)
            {

            }
        }
        return $this->parseViewConds($view, $varValues);
    }


    /*
     * Parses @extend constructions that adds another code in file
     */
    /**
     * @param string $view
     * @return string
     * @throws Exception
     */
    private function parseViewExtends(string $view): string
    {
        preg_match_all('/@extend\(.+?\)/s', $view, $extends);

        if (!$extends)
            return $view;

        foreach ($extends as $extend)
        {
            preg_match('/\(.+?\)/s', $extend, $extendName);
            preg_replace($extend, $this->getView('extend', $extendName . '.ext.php'), $extend);
        }

        return $this->parseViewExtends($view);
    }
}