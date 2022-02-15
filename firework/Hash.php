<?php

namespace Firework;

use Config\Config;

class Hash
{
    /**
     * @param string $data
     * @return array
     */
    public function hash(string $data): array
    {
        $config = new Config();
        $salt = $config->getSalt();

        return [hash("sha3-512", $data . $salt), $salt];
    }
}