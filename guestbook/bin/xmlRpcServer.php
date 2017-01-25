<?php

require_once(__DIR__ . '/../vendor/autoload.php');

use Guestbook\Entity\Greeter;
use Zend\XmlRpc\Server;

    $server = new Server;

    // Our 'Greeter' class will be called greeter from the client
    $server->setClass(Greeter::class /*<1>*/, 'greeter' /*<2>*/);

    return $server->handle();
