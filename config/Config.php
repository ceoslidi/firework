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

    public function getDatabase(): array
    {
        return $this->database;
    }

    private function setSalt()
    {
        $this->salt = openssl_random_pseudo_bytes(16);
    }

    public function getSalt(): string
    {
        $this->setSalt();
        return $this->salt;
    }
}