<?php

namespace Firework;

use Dotenv\Dotenv;

/*
 Class loads .env file.
 Includes
  constructor.
 */
class Env
{
    public function __construct()
    {
        $dotenv = Dotenv::createUnsafeImmutable(__DIR__ . '/../');
        $dotenv->load();
    }
}