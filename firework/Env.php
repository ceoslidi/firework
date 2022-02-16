<?php

namespace Firework;

use Dotenv\Dotenv;

class Env
{
    public function __construct()
    {
        $dotenv = Dotenv::createUnsafeImmutable(__DIR__ . '/../');
        $dotenv->load();
    }

    /**
     * @param string $env
     * @return bool
     */
    public function putContent(string $env): bool
    {
        $put = file_put_contents(__DIR__ . '/../.env', $env, FILE_APPEND);

        if ($put)
            return true;
        else
            return false;
    }
}