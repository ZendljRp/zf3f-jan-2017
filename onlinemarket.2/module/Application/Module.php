<?php
namespace Application;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Zend\Mail\Transport;
use Zend\Log;

class Module
{
    public function onBootstrap(MvcEvent $e)
    {
        $eventManager        = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);
        // attach listener to mvc "dispatch" event
        $eventManager->attach(MvcEvent::EVENT_DISPATCH, array($this, 'anything'), 100);
    }

    public function anything(MvcEvent $e) 
    { 
        $svcMgr = $e->getApplication()->getServiceManager();
        $view = $e->getViewModel();
        $view->setVariable('categories', $svcMgr->get('application-categories'));
        $view->setVariable('leftCol', $svcMgr->get('left-col-label'));
    }
    
    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

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
    
    public function getServiceConfig()
    {
        return array(
            'services' => array(
                'left-col-label' => 'MENU 1',
                'application-email-info' => array(
                	'to'	=> 'admin@company.com',
                	'from'	=> 'market@company.com',
                	'dir'	=> realpath(__DIR__ . '/../../data/logs'),
                ),
                'application-log-file' => realpath(__DIR__ . '/../../data/logs') . DIRECTORY_SEPARATOR . 'items_viewed.log',
            ),
            'factories' => array(
                'application-mail-transport' => function ($sm) {
                    $emailInfo = $sm->get('application-email-info');
                    $transOptions = array('path' => $emailInfo['dir']);
                    $transport = new Transport\File(new Transport\FileOptions($transOptions));
                    //$transport = new Transport\Sendmail();
                    return $transport;                    
                },
                'application-logger' => function ($sm) {
                    $writer = new Log\Writer\Stream($sm->get('application-log-file'));
                    $formatter = new Log\Formatter\Simple('%timestamp% | %message%');
                    $writer->setFormatter($formatter);
                    $logger = new Log\Logger();
                    $logger->addWriter($writer);
                    return $logger;
                },
                'application-session' => function ($sm) {
                    return new \Zend\Session\Container('application_session');
                }
            ),
        );
    }
}
