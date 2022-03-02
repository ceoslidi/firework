<?php

namespace App\Controllers;

class Curl
{
    private $curl;

    public function __construct()
    {
        $this->curl = curl_init();
    }

    /**
     * @param string $url
     * @param array $query
     * @return bool|string
     */
    public function send(string $url, array $query): bool|string
    {
        curl_setopt_array($this->curl, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => http_build_query($query)
        ]);

        return curl_exec($this->curl);
    }
}