<?php

namespace Config;

class Config
{
    private $database = [
        'host' => '46.0.203.139',
        'user' => 'root',
        'password' => 'YanSvin2007!',
        'database' => 'slidi'
    ];

    public function getDatabase()
    {
        return $this->database;
    }
}