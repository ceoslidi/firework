<?php

use Firework\Database;

/*
 * Class runs another processes.
 * Includes:
 *  constructor,
 *  private run method.
 */
class Run
{
    private Database $database;

    public function __construct()
    {
        $this->run();
        $this->database = new Database();
    }

    /*
     * Runs the main process.
     */
    /**
     * @return void
     * @throws Exception
     */
    private function run(): void
    {
        $this->connection = $this->database->connect();

        if ($this->connection) shell_exec("php -S 127.0.0.1:8000");
        else throw new Exception('Connection to Database is impossible.');
    }
}