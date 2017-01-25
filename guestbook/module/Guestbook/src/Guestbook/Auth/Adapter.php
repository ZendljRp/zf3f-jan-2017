<?php

namespace Guestbook\Auth;

use Zend\Authentication\Adapter\AdapterInterface;
use Zend\Authentication\Exception\ExceptionInterface;
use Zend\Authentication\Result;

/**
 * Class Adapter
 * @package Guestbook\Auth
 */
class Adapter implements AdapterInterface
{
    /**
     * Adapter constructor.
     * Sets the username and password to use for authentication
     *
     * @param string $username
     * @param string $password
     * @return void
     */
    public function __construct($username, $password)
    {
        // ...
    }

    /**
     * Performs an authentication attempt
     * @return Result
     * @throws ExceptionInterface
     */
    public function authenticate()
    {
        // ...
    }
}
