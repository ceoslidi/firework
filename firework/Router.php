<?php

namespace Firework;

class Router
{
    private $getRoutes = [];
    private $postRoutes = [];

    private $requestUrl = '';
    private $requestMethod = '';

    public function __destruct()
    {
        error_reporting(E_ALL & ~E_DEPRECATED);

        $url = $_SERVER['REQUEST_URI'];
        $queryPost = strrpos($url, "?");
        $redirectUrl = '';

        if ($queryPost) {
            $redirectUrl = substr($url, 0, $queryPost);
        } else {
            $redirectUrl = $url;
        }

        $this->requestUrl = $redirectUrl;
        $this->requestMethod = $_SERVER['REQUEST_METHOD'];

        $this->request($this->requestUrl, $this->requestMethod);
    }

    /**
     * @param string $requestUrl
     * @param string $requestMethod
     * @return void
     */
    private function request(string $requestUrl, string $requestMethod)
    {
        if (in_array($requestUrl, $this->getRoutes) || in_array($requestUrl, $this->postRoutes)) {
            switch ($requestMethod)
            {
                case 'GET':
                    $handler = $this->getRoutes[$requestUrl];
                    break;
                case 'POST':
                    $handler = $this->postRoutes[$requestUrl];
                    break;
                default:
                    throw new Error('Unknown request method');
            }

            $class = $handler[0];
            $method = $handler[1];

            call_user_func([$class, $method]);
        } else {
            $this->throwNotFound();
        }
    }

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

    public function post(string $url, array $handler)
    {
        $this->postRoutes[$url] = $handler;
    }
}