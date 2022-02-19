<?php

namespace App\Controllers;

use Firework\Database;
use Firework\Hash;

use Config\Config;

class HomeController
{
    public static function render()
    {
        $database = new Database();
        $hash = new Hash();
        $config = new Config();

        echo '<pre>';
        print_r($hash->hash('zhopa'));
        print_r($database->connect()->delete('users', ['username' => 'xuy']));
        echo '</pre>';
    }

    public function response()
    {
        echo 'pizdas';
    }
}