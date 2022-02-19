<?php

namespace Firework;

class Session
{
    public function construct()
    {
        session_start();
    }

    /**
     * @param string $key
     * @return mixed
     */
    public function get(string $key): mixed
    {
        $result = isset($_SESSION[$key]);

        if ($result) {
            return $_SESSION[$key];
        } else {
            return false;
        }
    }

    /**
     * @param string $key
     * @param string $value
     * @return bool
     */
    public function set(string $key, string $value): bool
    {
        $result = ($_SESSION[$key] = $value);

        if ($result) {
            return true;
        } else {
            return false;
        }
    }
}