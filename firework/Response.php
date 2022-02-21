<?php

namespace Firework;

/*
 Class encodes data into the JSON object.
 Includes
  public reply method.
 */
class Response
{
    /*
     Encodes data into the JSON object.
     */
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