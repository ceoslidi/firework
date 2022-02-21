<?php

/*
 Class controls interactions during installation.
 Includes:
  constructor,
  private setDatabase method,
  private setSalt method,
  private setUploadDir method.
 */
class Installer {
    public function __construct()
    {
        $this->setDatabase();
        $this->setSalt();
        $this->setUploadsDir();
    }

    /*
     Sets up the database and writes its data in .env.
     */
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

    /*
     Sets up the salt (length = 16) and writes its data in .env.
     */
    /**
     * @return void
     */
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

    /*
     Sets up the upload dir and writes its path in .env.
     */
    /**
     * @return void
     */
    private function setUploadsDir(): void
    {
        $file = PHP_EOL . PHP_EOL . "UPLOADS_DIR=" . trim(fgets(STDIN));

        $fileResponse = file_put_contents(__DIR__ . '/../.env', $file, FILE_APPEND);

        file_put_contents(__DIR__ . '/../.env', PHP_EOL . "UPLOADS_MAX_SIZE=500000", FILE_APPEND);
        file_put_contents(__DIR__ . '/../.env', PHP_EOL . "UPLOADS_MIME_IMAGE=1", FILE_APPEND);

        if ($fileResponse)
            fwrite(STDOUT, "UPLOADS: SUCCESS!" . PHP_EOL);
        else
            fwrite(STDOUT, "SALT: Something went wrong!" . PHP_EOL);
    }
}