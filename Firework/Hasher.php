<?php

namespace Firework;

class Hasher
{
    public function hash(string $data, string $salt)
    {
        return [hash("sha3-512", $data . $salt), $salt];
    }
}