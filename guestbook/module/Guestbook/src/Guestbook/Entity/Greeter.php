<?php

namespace Guestbook\Entity;


class Greeter
{

    /**
     * Say hello to someone.
     *
     * @param string $name The name of the person to greet
     * @return string
     */
    public function sayHello($name = 'Stranger')
    {
        return sprintf("Hello %s!\n", $name);
    }
}
