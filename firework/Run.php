<?php

/*
 Class runs another processes
 Includes:
  constructor,
  private run method.
 */
class Run
{
    public function __construct()
    {
        $this->run();
    }

//    Runs the main process.
    /**
     * @return void
     */
    private function run(): void
    {
        shell_exec("php -S 127.0.0.1:8000");
    }
}