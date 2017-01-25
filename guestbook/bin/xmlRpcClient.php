<?php

require_once(__DIR__ . '/../vendor/autoload.php');

$client = new Zend\XmlRpc\Client('http://localhost:8080');

echo $client->call('greeter.sayHello');
// will output "Hello Stranger!"

echo $client->call('greeter.sayHello', array('Dude'));
// will output "Hello Dude!"

