<?php

namespace Firework;

use Firework\Database;
use Firework\File;
use Firework\Hash;
use Firework\Session;
use Firework\View;

/*
 * Class is a main constructor.
 *  Includes
 *   constructor.
 */
class Controller
{
    public Database $database;
    public File $file;
    public Hash $hash;
    public Session $session;
    public View $view;

    public function __construct()
    {
        $this->database = new Database();
        $this->file = new File();
        $this->hash = new Hash();
        $this->session = new Session();
        $this->view = new View();
    }
}