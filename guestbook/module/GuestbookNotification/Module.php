<?php
namespace GuestbookNotification;

use Application\Service\AppService;
use Guestbook\Service\Entry;
use Zend\ModuleManager\ModuleManager;
use Zend\EventManager\EventInterface;
use Zend\Mail\Message;
use Zend\Mail\Transport;
use Zend\ModuleManager\Feature\BootstrapListenerInterface;

/**
 * Class Module
 * @package GuestbookNotification
 */
class Module implements BootstrapListenerInterface
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
        $sm = $event->getApplication()->getServiceManager();
        $sm->get(Entry::class)->getEventManager()->attach(
            'add.post',
            array($this, 'onNewEntry')
        );
    }

    /**
     * @param EventInterface $event
     */
    public function onNewEntry(EventInterface $event)
    {
        $message = new Message();
        $message->addFrom('noreply@localhost', 'Guestbook Notifier')
            ->addTo($event->getParam('entry')->getEmail())
            ->setSubject('Thank you!')
            ->setBody('Thank you for leaving a guestbook entry!')
            ->setEncoding('utf-8');

        //$transport = new Transport\Sendmail();
        $options = new Transport\FileOptions(array('path' => realpath(__DIR__ . '/../../data/')));
        $transport = new Transport\File($options);
        $transport->send($message);
    }
}
