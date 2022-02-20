<?php

namespace App\Controllers;

use Firework\Database;
use Firework\Hash;
use Firework\Session;

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

        echo '<pre>';
        $get = $request->get;
        print_r($get['axuy']);
        $response->reply(['status' => 'success']);
        echo '</pre>';
    }

    public function response()
    {
        echo 'pizdas';
    }
}