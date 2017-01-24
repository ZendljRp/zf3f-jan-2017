<?php
namespace Tutorial\Form\Factory;

use Zend\Form\Factory;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

class FormFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return (new Factory())->createForm($container->get('tutorial-form-config'));
    }
}
