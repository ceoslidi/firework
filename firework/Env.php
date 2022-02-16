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
}