<?php

namespace Firework;

/*
 * Class matches the redirect url and request method.
 * Includes:
 *  constructor,
 *  private getRedirectURL method,
 *  private getRequestMethod.
 */
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

        $this->getRedirectURL();
        $this->getRequestMethod();
    }

    /*
     * Parses URL which will be redirected to.
     */
    /**
     * @return void
     */
    private function getRedirectURL(): void
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

    /*
     * Parses request method.
     */
    /**
     * @return void
     */
    private function getRequestMethod(): void
    {
        $this->requestMethod = $_SERVER['REQUEST_METHOD'];
    }
}