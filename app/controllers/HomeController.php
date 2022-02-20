<?php

namespace App\Controllers;

use Firework\Controller;

class HomeController extends Controller
{
    private string $name = 'xui';

    public function render($request, $response)
    {
        $obj = [];

        $this->view->renderView('home', $obj);
    }

    public function filer($request, $response)
    {
        $this->file->upload('image');
        $response->reply(['status' => 'success']);
    }
}