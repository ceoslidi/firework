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
        $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyz!@#$%^&*()';

        return substr(str_shuffle($permitted_chars), 0, $length);
    }
}