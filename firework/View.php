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
 *  private parseViewConds method,
 *  private parseViewExtends method.
 */
class View {
    /*
     * Renders and returns code of view with defined name.
     */
    /**
     * @param string $viewName
     * @param array $varValues
     * @return string
     * @throws Exception
     */
    public function renderView(string $viewName, array $varValues): string
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
        $csrf = new Csrf();

        $token = $csrf->generateToken();


        if (!$view) throw new Exception('Error: something went wrong in rendering your view.');

        foreach ($matches as $elem)
        {
            $str = $data[$elem];
            $view = str_replace($elem, $str, $view);
        }

        print_r(htmlspecialchars_decode($view));
        return $token;
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
        $view = match ($fileType) {
            'view' => file_get_contents(urldecode(__DIR__ . '/../app/views/' . $fileName)),
            'extend' => file_get_contents(urldecode(__DIR__ . '/../app/views/extends' . $fileName)),
            default => throw new Exception('Error: undefined view type.'),
        };

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
        /*
            Parsing's divided into two steps to increase performance.
            1) We go through all the characters in the view,
            look for blocks that may contain dynamic content.
            2) Then perform a full check with a regexp.
        */
        $t = ''; // Each block will be here
        $canBeLoopBlock = [];
        for ($i = 0; $i < mb_strlen($view); $i++) {
            $char = mb_substr($view, $i, 1);
            if ($char == '@' || strpos($t, '@'))
                $t .= $char;

            $starts = strpos($t, '@foreach');
            $ends = strpos($t, '@endforeach');

            if ($starts && $ends)
                if ($starts - $ends == 0)
                    array_pop($canBeLoopBlock) xor array_push($canBeLoopBlock, $t); // Add $t to last elem
                    $t = '';
        }


        $loops = [];

        foreach($canBeLoopBlock as $m)
        {
            preg_match('/'
                .'@foreach\s*?' // Matches start of loop, '@foreach'.
                .'\(\s*?{{[a-zA-Z_\x80-\xff][a-zA-Z0-9_\x80-\xff]*}}\s+?' // Var with any possible name,
                // bracket and whitespaces, '($var'
                .'as\s+?' // 'as'.
                .'{{[a-zA-Z_\x80-\xff][a-zA-Z0-9_\x80-\xff]*?}}\s*?\)' // Second var, '$var)'.
                .'.+?' // Any code inside.
                .'@endforeach/s', // End of loop '@endforeach'.
                $m,
                $l);
            $loops[] = $l[0];
        }

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
        /*
            Parsing's divided into two steps to increase performance.
            1) We go through all the characters in the view,
            look for blocks that may contain dynamic content.
            2) Then perform a full check with a regexp.
        */
        $t = ''; // Each block will be here
        $canBeCondBlock = [];
        for ($i = 0; $i < mb_strlen($view); $i++) {
            $char = mb_substr($view, $i, 1);
            if ($char == '@' || strpos($t, '@'))
                $t .= $char;

            $starts = strpos($t, '@if');
            $ends = strpos($t, '@endif');

            if ($starts && $ends)
                if ($starts - $ends == 0)
                    array_pop($canBeCondBlock) xor array_push($canBeCondBlock, $t); // Add $t to last elem
            $t = '';
        }


        $condBlocks = [];

        foreach($canBeCondBlock as $m)
        {
            preg_match('/@if\s*\(.+\).+?@endif/s',
                $m,
                $c);
            $condBlocks[] = $c[0];
        }

        if (!$condBlocks)
            return $view;

        foreach ($condBlocks as $condBlock)
        {
            preg_match_all('/\(.+/\)/', $condBlock, $conds);
            $t = '';
            foreach ($conds as $cond)
            {
                if (eval($cond))
                {
                    preg_match('/'
                            . '\(\s*'
                            . $cond
                            . '\)\s*'
                            . '.+?(?=@elif|@else|@endif)'
                            . '/s',
                        $condBlock,
                        $code);
                    $code = preg_replace('/\s*' . $cond . '\s*/', '', $code[0], 1);
                    preg_replace($condBlock, $code, $view);

                    $t = $cond;
                    break;
                }
            }

            if ($t == $conds[array_key_last($conds)] && !$t) {
                preg_match('/(?=@else).+?@endif/s', $conds, $code);
                $code = preg_replace('/@endif/', '', $code[0], 1);
                preg_replace($condBlock, $code, $view);
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
            $extendName = $extendName[0];
            preg_replace($extend, $this->getView('extend', $extendName . '.ext.php'), $extend);
        }

        return $this->parseViewExtends($view);
    }
}
