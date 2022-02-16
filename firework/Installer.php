<?php

class Installer {
    public function __construct()
    {
        $this->setDatabase();
        $this->setSalt();
    }

    /**
     * @return void
     */
    private function setDatabase(): void
    {
        fwrite(STDOUT, "Enter Database Host:" . PHP_EOL);
        $host = "DATABASE_HOST=" . trim(fgets(STDIN));

        fwrite(STDOUT, "Enter Database User:" . PHP_EOL);
        $user = PHP_EOL . "DATABASE_USER=" . trim(fgets(STDIN));

        fwrite(STDOUT, "Enter Database Password:" . PHP_EOL);
        $password = PHP_EOL . "DATABASE_PASSWORD=" . trim(fgets(STDIN));

        fwrite(STDOUT, "Enter Database Name:" . PHP_EOL);
        $database = PHP_EOL . "DATABASE_NAME=" . trim(fgets(STDIN));

        $hostResponse = file_put_contents(__DIR__ . '/../.env', $host, FILE_APPEND);
        $userResponse = file_put_contents(__DIR__ . '/../.env', $user, FILE_APPEND);
        $passwordResponse = file_put_contents(__DIR__ . '/../.env', $password, FILE_APPEND);
        $databaseResponse = file_put_contents(__DIR__ . '/../.env', $database, FILE_APPEND);

        if ($hostResponse && $userResponse && $passwordResponse && $databaseResponse)
            fwrite(STDOUT, "DATABASE: SUCCESS!" . PHP_EOL);
        else
            fwrite(STDOUT, "DATABASE: Something went wrong!" . PHP_EOL);
    }

    private function setSalt(): void
    {
        $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyz!@$%^&*()';

        $salt = PHP_EOL . PHP_EOL . "SALT=" . substr(str_shuffle($permitted_chars), 0, 16);

        $saltResponse = file_put_contents(__DIR__ . '/../.env', $salt, FILE_APPEND);

        if ($saltResponse)
            fwrite(STDOUT, "SALT: SUCCESS!" . PHP_EOL);
        else
            fwrite(STDOUT, "SALT: Something went wrong!" . PHP_EOL);
    }
}