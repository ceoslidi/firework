<?php

namespace App\Controllers;

use Firework\Database;
use Firework\Hash;
use Firework\Session;
use Firework\File;
use Firework\View;

use Config\Config;

class HomeController
{
    private string $name = 'xui';

    public function render($request, $response)
    {
        $view = new View();

        $obj = [];

        $view->renderView('home', $obj);
    }

    public function filer($request, $response)
    {
        $file = new File();

        $file->upload('xui');
        $response->reply(['status' => 'success']);
    }

    public function response()
    {
        echo 'pizdas';
    }
}