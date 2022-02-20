<?php

namespace Firework;

class Response
{
    /**
     * @param array $options
     * @return bool
     */
    public function reply(array $options): bool
    {
        $json = json_encode($options);

        if ($json) {
            echo $json;
            return true;
        } else {
            return false;
        }
    }
}