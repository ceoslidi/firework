<?php

namespace Config;

use Firework\Env;

class Config
{
    public function __construct()
    {
        $env = new Env();
    }

    /**
     * @return array
     */
    public function getDatabase(): array
    {
        return [
            'host' => getenv('DATABASE_HOST'),
            'user' => getenv('DATABASE_USER'),
            'password' => getenv('DATABASE_PASSWORD'),
            'database' => getenv('DATABASE_NAME'),
        ];
    }

    /**
     * @return string
     */
    public function getSalt(): string
    {
        return getenv('SALT');
    }

    /**
     * @return array
     */
    public function getUploadsSettings(): array
    {
        return [
            'dir' => getenv('UPLOADS_DIR'),
            'maxSize' => getenv('UPLOADS_MAX_SIZE'),
            'onlyImage' => getenv('UPLOADS_MIME_IMAGE'),
        ];
    }
}