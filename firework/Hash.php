<?php
namespace Firework;
use Config\Config;

class Hash
{
    public function hash(string $data, string $salt): array
    {
        return [hash("sha3-512", $data . $salt), $salt];
    }

    public function newSalt(): string
    {
        $config = new Config;
        return $config->getSalt();
    }
}