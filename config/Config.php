<?php

namespace Config;

use Firework\Env;
use JetBrains\PhpStorm\ArrayShape;

/*
 Class writes data into the .env.
 Includes:
  constructor,
  public getDatabase method
 */
class Config
{
    public function __construct()
    {
        $env = new Env();
    }

    /*
     Gets the database information from .env.
     */
    /**
     * @return array
     */
    #[ArrayShape([
        'host' => "false|string",
        'user' => "false|string",
        'password' => "false|string",
        'database' => "false|string"
    ])]
    public function getDatabase(): array
    {
        return [
            'host' => getenv('DATABASE_HOST'),
            'user' => getenv('DATABASE_USER'),
            'password' => getenv('DATABASE_PASSWORD'),
            'database' => getenv('DATABASE_NAME'),
        ];
    }

    /*
     Gets salt from the .env.
     */
    /**
     * @return string
     */
    public function getSalt(): string
    {
        return getenv('SALT');
    }

    /*
     Gets upload settings from .env.
     */
    /**
     * @return array
     */
    #[ArrayShape([
        'dir' => "false|string",
        'maxSize' => "false|string",
        'onlyImage' => "false|string"
    ])]
    public function getUploadsSettings(): array
    {
        return [
            'dir' => getenv('UPLOADS_DIR'),
            'maxSize' => getenv('UPLOADS_MAX_SIZE'),
            'onlyImage' => getenv('UPLOADS_MIME_IMAGE'),
        ];
    }
}