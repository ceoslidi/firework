<?php

namespace Firework;

use Error;

use Firework\Response;
use Firework\Request;

/*
 * Class controls the app's routes.
 * Includes:
 *  constructor,
 *  public get method,
 *  public post method,
 *  private request method,
 *  private throwNotFound method,
 *  destructor.
 */
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

    /*
     * Detects the request protocol for URL or returns 404.
     */
    /**
     * @param string $requestUrl
     * @param string $requestMethod
     * @return void
     */
    private function request(string $requestUrl, string $requestMethod): void
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

    /*
     * Returns 404 error page.
     */
    /**
     * @return void
     */
    private function throwNotFound(): void
    {
        print_r('404');
//        TODO: view for error pages.
    }

    /*
     * Parses in-request data got with get method.
     */
    /**
     * @param string $url
     * @param array $handler
     * @return void
     */
    public function get(string $url, array $handler): void
    {
        $this->getRoutes[$url] = $handler;
    }

    /*
     * Parses in-request data got with post method.
     */
    /**
     * @param string $url
     * @param array $handler
     * @return void
     */
    public function post(string $url, array $handler): void
    {
        $this->postRoutes[$url] = $handler;
    }
}