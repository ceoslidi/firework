<?php

namespace Firework;

class Hasher
{
    public function hash(string $data, string $salt)
    {
        if (!$salt)
            $salt = openssl_random_pseudo_bytes(strlen($data));

        return [hash("sha3-512", $data . $salt), $salt];
    }
}