<?php

namespace Firework;

/*
 * Class controls session interactions.
 * Includes:
 *  public function construct,
 *  public get function,
 *  public set function.
 */
class Session
{
    public function construct()
    {
        session_start();
    }

    /*
     * Gets data from the $_SESSION.
     */
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

    /*
     * Puts data into the $_SESSION.
     */
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