<?php

namespace Firework;

class Generate
{
    /**
     * @param int $length
     * @return string
     */
    public function generateString(int $length): string
    {
        $chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ!@$%^&*()_+-=';

        return substr(str_shuffle($chars), 0, $length);
    }
}