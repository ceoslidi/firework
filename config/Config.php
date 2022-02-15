<?php

namespace Config;

class Config
{
    private array $database = [
        'host' => '46.0.203.139',
        'user' => 'root',
        'password' => 'YanSvin2007!',
        'database' => 'slidi'
    ];
    private string $salt = '';

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
        $this->salt = openssl_random_pseudo_bytes(16);

        return true;
    }

    /**
     * @return string
     */
    public function getSalt(): string
    {
        return $this->salt;
    }
}