<?php

namespace Firework;

use Firework\Session;
use Firework\Generate;
use Firework\Hash;
use Firework\Request;

class Csrf
{
    private Session $session;
    private Generate $generate;
    private Hash $hash;
    private Request $request;

    public function __construct()
    {
        $this->session = new Session();
        $this->generate = new Generate();
        $this->hash = new Hash();
        $this->request = new Request();

        $csrf = $this->session->get('secret');
        if (!$csrf) $this->session->set('secret', $this->generate->generateString(8));
    }

    /**
     * @return string
     */
    public function generateToken(): string
    {
        $salt = $this->generate->generateString(8);
        $hash = $this->hash->hash($salt . ":" . $this->session->get('secret'));
        return $salt . ":" . $hash[0];
    }

    public function checkToken()
    {
        if ($this->request->requestMethod == 'POST')
        {
            $post = $this->request->post;
            $token = $post['csrf'];

            $arr = explode(":", $token);
            $salt = $arr[0];
            $hash = $this->hash->hash($salt . ":" . $this->session->get('secret'));
            $newToken = $salt . ":" . $hash[0];

            if ($token === $newToken) return true;
            else throw new \Exception('Unknown CSRF token');
        }
    }
}