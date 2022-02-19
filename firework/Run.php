<?php

class Run
{
    public function __construct()
    {
        $this->run();
    }

    private function run()
    {
        shell_exec("php -S 127.0.0.1:8000");
    }
}