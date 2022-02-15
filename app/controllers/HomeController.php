<?php

namespace App\Controllers;

use Firework\Database;

class HomeController
{
    public static function render()
    {
        $database = new Database();

        echo '<pre>';
        print_r($database->connect()->select(
            ['username', 'password', 'token', 'id', 'isActive'],
            [
                'username' => 'ya'
            ]
        ));
        echo '</pre>';
    }

    public function response()
    {
        echo 'pizdas';
    }
}