<?php

namespace App\Controllers;

use Firework\Database;
use Firework\Hash;
use Firework\Session;

use Config\Config;

class HomeController
{
    public static function render()
    {
        $database = new Database();
        $hash = new Hash();
        $config = new Config();
        $session = new Session();

        echo '<pre>';
        print_r($hash->hash('zhopa'));
        print_r($database->connect()->delete('users', ['username' => 'xuy']));
        print_r($session->set("xui", "aue"));
        print_r($session->get("xui"));
        echo '</pre>';
    }

    public function response()
    {
        echo 'pizdas';
    }
}