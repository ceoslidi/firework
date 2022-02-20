<?php

namespace Firework;

use Error;

use Firework\Response;
use Firework\Request;

class Router
{
    private array $getRoutes;
    private array $postRoutes;

    private Request $request;
    private Response $response;

    public function __construct()
    {
        $this->request = new Request();
        $this->response = new Response();
    }

    public function __destruct()
    {
        error_reporting(E_ALL & ~E_DEPRECATED);

        $this->request($this->request->requestUrl, $this->request->requestMethod);
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

            call_user_func([$class, $method], $this->request, $this->response);
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