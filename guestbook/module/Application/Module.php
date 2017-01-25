<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application;

use Application\Service\AppService;
use Zend\EventManager\EventInterface;
use Zend\Log\Logger;
use Zend\Log\Writer\Stream as StreamWriter;
use Zend\ModuleManager\ModuleManager;
use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\ModuleManager\Feature\BootstrapListenerInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\ModuleManager\Feature\ServiceProviderInterface;
use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;

/**
 * Class Module
 * @package Application
 */
class Module implements
    AutoloaderProviderInterface,
    BootstrapListenerInterface,
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
     * @param EventInterface $event
     */
    public function onBootstrap(EventInterface $event)
    {
        $eventManager = $event->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);

        $eventManager->getSharedManager()->attach('anyEvent', '*',
            function (EventInterface $event) {
                // collects event names
                AppService::$eventsCalled[] = __NAMESPACE__ . $event->getName() . ':' . get_class($event->getTarget());
            });

        $eventManager->getSharedManager()->attach(
            'Zend\Stdlib\DispatchableInterface',
            MvcEvent::EVENT_DISPATCH,
            function (MvcEvent $event) {
                $sm = $event->getApplication()->getServiceManager();
                $request = $event->getRequest();
                $logger = $sm->get(Logger::class);

                $logger->debug(sprintf(
                    'Incoming request was of type %s',
                    get_class($request)
                ));
                $logger->info(sprintf(
                    'Events: %s',
                    implode(PHP_EOL, AppService::$eventsCalled)
                ));
            }
        );

    }

    /**
     * @return mixed
     */
    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    /**
     * @return array
     */
    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

    /**
     * @return array
     */
    public function getServiceConfig()
    {
        return array(
            'factories' => array(
                Logger::class => function ($sm) {
                    $writer = new StreamWriter('data/application.log');
                    $logger = new Logger();
                    $logger->addWriter($writer);

                    return $logger;
                },
            ),
        );
    }
}
