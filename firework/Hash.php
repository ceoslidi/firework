<?php

namespace Firework;

use Config\Config;

/*
 Controls interactions with hashing data. Uses SHA3-512 and salt from .env.
 Includes
  public hash method.
 */
class Hash
{
    /*
     Hashes string using SHA3-512 and salt with length 16.
     */
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