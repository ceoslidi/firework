<?php
namespace Firework;

class Hasher
{
    public function hash(string $data, string $salt)
    {
        return [hash("sha3-512", $data . $salt), $salt];
    }

    public function new_salt()
    {
        return openssl_random_pseudo_bytes(16);
    }
}