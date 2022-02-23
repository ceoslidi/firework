<?php

namespace App\Controllers;

use Firework\Controller;

class FirstController extends Controller
{
    /**
     * Render first.fire.php view
     * @return void
     */
    public function render(): void
    {
        $this->view->renderView('first', [

        ]);
    }
}