<?php

namespace App\Controllers;

use Firework\Database;
use Firework\Hash;
use Firework\Session;
use Firework\File;

use Config\Config;

class HomeController
{
    private string $name = 'xui';

    public function render($request, $response)
    {
        $database = new Database();
        $hash = new Hash();
        $config = new Config();
        $session = new Session();
        $file = new File();

        echo '<pre>';
        print_r($file->upload());
        echo '</pre>';
    }

    public function response()
    {
        echo 'pizdas';
    }
}