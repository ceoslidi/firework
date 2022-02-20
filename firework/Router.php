<?php

namespace Firework;

use Error;

class Router
{
    private array $getRoutes = [];
    private array $postRoutes = [];

    private string $requestUrl = '';
    private string $requestMethod = '';

    private array $get = [];
    private array $post = [];

    public function __destruct()
    {
        error_reporting(E_ALL & ~E_DEPRECATED);

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
        $this->requestMethod = $_SERVER['REQUEST_METHOD'];

        $this->get = $_GET;

        $this->request($this->requestUrl, $this->requestMethod);
    }

    /**
     * @param string $requestUrl
     * @param string $requestMethod
     * @return void
     */
    private function request(string $requestUrl, string $requestMethod)
    {
        if (isset($this->getRoutes[$requestUrl]) || isset($this->postRoutes[$requestUrl])) {
            $handler = match ($requestMethod) {
                'GET' => $this->getRoutes[$requestUrl],
                'POST' => $this->postRoutes[$requestUrl],
                default => throw new Error('Unknown request method'),
            };

            $class = new $handler[0]();
            $method = $handler[1];

            switch ($requestMethod)
            {
                case 'GET':
                    call_user_func([$class, $method], $this->get);
                    break;
                case 'POST':
                    call_user_func([$class, $method], $this->post);
                    break;
                default:
                    throw new Error("Unknown request method");
                    break;
            }
        } else {
            $this->throwNotFound();
        }
    }

    /**
     * @return void
     */
    private function throwNotFound()
    {
        print_r('404');
    }

    /**
     * @param string $url
     * @param array $handler
     * @return void
     */
    public function get(string $url, array $handler)
    {
        $this->getRoutes[$url] = $handler;
    }

    /**
     * @param string $url
     * @param array $handler
     * @return void
     */
    public function post(string $url, array $handler)
    {
        $this->postRoutes[$url] = $handler;
    }
}