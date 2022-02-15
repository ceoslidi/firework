<?php

namespace Firework;

use Config\Config;

class Hash
{
    public function hash(string $data): array
    {
        $config = new Config();
        $salt = $config->getSalt();

        return [hash("sha3-512", $data . $salt), $salt];
    }
}