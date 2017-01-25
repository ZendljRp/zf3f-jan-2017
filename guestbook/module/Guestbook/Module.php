<?php

namespace Guestbook;

use Application\Service\AppService;
use Guestbook\Entity\Entry as EntryEntity;
use Guestbook\Form\EntryFilter;
use Guestbook\Mapper\EntryHydrator;
use Zend\ModuleManager\ModuleManager;
use Zend\EventManager\EventInterface;
use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\ModuleManager\Feature\ServiceProviderInterface;

/**
 * Class Module
 * @package Guestbook
 */
class Module implements
    AutoloaderProviderInterface,
    ConfigProviderInterface,
    ServiceProviderInterface
{
    /**
     * @param ModuleManager $moduleManager
     */
    public function init(ModuleManager $moduleManager)
    {
        $events = $moduleManager->getEventManager();
        // example of using a wildcard listener
        $events->attach('*', function (EventInterface $event) {
            // collects event names
            AppService::$eventsCalled[] = __NAMESPACE__ . $event->getName() . ':' . get_class($event->getTarget());
        });
    }

    /**
     * Informs the bootstrap process of the module config, required for module config
     * @return mixed
     */
    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    /**
     * Informs the bootstrap process of the namespace for the standard autoloader config.
     * @return array
     */
    public function getAutoloaderConfig()
    {
        return [
            'Zend\Loader\StandardAutoloader' => [
                'namespaces' => [
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ],
            ],
        ];
    }

    /**
     * @return array
     */
    public function getServiceConfig()
    {
        return array(
            'invokables' => [
                EntryFilter::class => EntryFilter::class,
                EntryHydrator::class => EntryHydrator::class,
                EntryEntity::class => EntryEntity::class,
            ],
        );
    }
}
