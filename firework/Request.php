<?php

namespace Firework;

class Request
{
    public array $get;
    public array $post;

    public string $requestUrl;
    public string $requestMethod;

    public function __construct()
    {
        $this->get = $_GET;
        $this->post = $_POST;

        $this->getRedirectUrl();
        $this->getRequestMethod();
    }

    /**
     * @return void
     */
    private function getRedirectUrl(): void
    {
        $url = $_SERVER['REQUEST_URI'];
        $queryPost = strrpos($url, "?");

        $redirectUrl = '';
        $requestQuery = [];

        if ($queryPost) {
            $redirectUrl = substr($url, 0, $queryPost);
        } else {
            $redirectUrl = $url;
        }

        $this->requestUrl = $redirectUrl;
    }

    /**
     * @return void
     */
    private function getRequestMethod(): void
    {
        $this->requestMethod = $_SERVER['REQUEST_METHOD'];
    }
}