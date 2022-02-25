<?php

namespace Firework;

use Firework\Request;

class Logger
{
    private Request $request;

    public function __construct()
    {
        $this->request = new Request();
        $this->log();
    }

    /**
     * @return void
     */
    public function log(): void
    {
        $ip = $this->request->ip;
        $target = __DIR__ . '/../process.log';
        $log =
            $ip .
            " - " .
            $this->request->requestUrl .
            " " .
            $this->request->requestMethod .
            " at " .
            date('d.m.Y, H:i:s') .
            PHP_EOL;

        file_put_contents($target, $log, FILE_APPEND);
    }
}