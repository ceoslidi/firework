<?php

namespace App\Controllers;

use Firework\Database;
use Firework\Hash;
use Firework\Session;

use Config\Config;

class HomeController
{
    private string $name = 'xui';

    public function render(array $request)
    {
        $database = new Database();
        $hash = new Hash();
        $config = new Config();
        $session = new Session();

        echo '<pre>';
        echo '</pre>';
    }

    public function response()
    {
        echo 'pizdas';
    }
}