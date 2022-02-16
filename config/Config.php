<?php

namespace Config;

use Firework\Env;
use Firework\Generate;

class Config
{
    private Generate $generate;
    private Env $env;

    public function __construct()
    {
        $env = new Env();
        $this->env = $env;

        $generate = new Generate();
        $this->generate = $generate;
    }

    private array $database = [
        'host' => '46.0.203.139',
        'user' => 'root',
        'password' => 'YanSvin2007!',
        'database' => 'slidi'
    ];

    /**
     * @param array $database
     * @return bool
     */
    public function setDatabase(array $database): bool
    {
        $this->database = $database;

        return true;
    }

    /**
     * @return array
     */
    public function getDatabase(): array
    {
        return $this->database;
    }

    /**
     * @return bool
     */
    public function setSalt(): bool
    {
        $env = PHP_EOL . "SALT=" . $this->generate->generateString(16);

        return $this->env->putContent($env);
    }

    /**
     * @return string
     */
    public function getSalt(): string
    {
        return getenv('salt');
    }
}