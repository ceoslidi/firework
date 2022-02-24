<?php

/*
 * Class controls interactions during installation.
 * Includes:
 *  constructor,
 *  private setDatabase method,
 *  private setSalt method,
 *  private setUploadDir method.
 */
class Installer {
    public function __construct()
    {
        $this->setDatabase();
        $this->setUploadsDir();
        $this->setSmtpSettings();
    }

    /*
     * Sets up the database and writes its data in .env.
     */
    /**
     * @return void
     */
    private function setDatabase(): void
    {
        $host = "DATABASE_HOST=";
        $user = PHP_EOL . "DATABASE_USER=";
        $password = PHP_EOL . "DATABASE_PASSWORD=";
        $database = PHP_EOL . "DATABASE_NAME=";

        file_put_contents(__DIR__ . '/../.env', $host, FILE_APPEND);
        file_put_contents(__DIR__ . '/../.env', $user, FILE_APPEND);
        file_put_contents(__DIR__ . '/../.env', $password, FILE_APPEND);
        file_put_contents(__DIR__ . '/../.env', $database, FILE_APPEND);

        fwrite(STDOUT, "DATABASE: SUCCESS!" . PHP_EOL);
    }

    /*
     * Sets up the upload dir and writes its path in .env.
     */
    /**
     * @return void
     */
    private function setUploadsDir(): void
    {
        $file = PHP_EOL . PHP_EOL . "UPLOADS_DIR=";

        file_put_contents(__DIR__ . '/../.env', $file, FILE_APPEND);

        file_put_contents(__DIR__ . '/../.env', PHP_EOL . "UPLOADS_MAX_SIZE=500000", FILE_APPEND);
        file_put_contents(__DIR__ . '/../.env', PHP_EOL . "UPLOADS_MIME_IMAGE=1", FILE_APPEND);

        fwrite(STDOUT, "UPLOADS: SUCCESS!" . PHP_EOL);
    }

    private function setSmtpSettings(): void
    {
        $smtp = PHP_EOL . PHP_EOL . "SMTP_HOST=";
        file_put_contents(__DIR__ . '/../.env', $smtp, FILE_APPEND);

        $smtp = PHP_EOL . "SMTP_USER=";
        file_put_contents(__DIR__ . '/../.env', $smtp, FILE_APPEND);

        $smtp = PHP_EOL . "SMTP_PASS=";
        file_put_contents(__DIR__ . '/../.env', $smtp, FILE_APPEND);

        $smtp = PHP_EOL . "SMTP_PORT=";
        file_put_contents(__DIR__ . '/../.env', $smtp, FILE_APPEND);

        fwrite(STDOUT, "SMTP: SUCCESS!" . PHP_EOL);
    }
}