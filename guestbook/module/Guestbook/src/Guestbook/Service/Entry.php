<?php
namespace Guestbook\Service;

use Guestbook\Entity\Entry as EntryEntity;
use Guestbook\Form\Entry as EntryForm;
use Guestbook\Mapper\Entry as EntryMapper;
use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\EventsCapableInterface;

/**
 * Class Entry
 * @package Guestbook\Service
 */
class Entry implements EventsCapableInterface
{
    /**
     * @var EventManagerInterface
     */
    protected $eventManager;

    /**
     * @var EntryMapper
     */
    protected $entryMapper;

    /**
     * @var EntryForm
     */
    private $entryForm;

    /**
     * Entry constructor.
     * @param EntryForm $entryForm
     */
    public function __construct(
        EntryForm $entryForm,
        EntryMapper $entryMapper,
        EventManagerInterface $eventManager
    ) {
        $this->entryForm = $entryForm;
        $this->entryMapper = $entryMapper;
        $this->eventManager = $eventManager;
    }

    /**
     * Add an entry to the Guestbook
     *
     * @param array $data
     * @return bool|EntryEntity
     */
    public function add(array $data)
    {
        $this->entryForm->bind(new EntryEntity());
        $this->entryForm->setData($data);

        if (!$this->entryForm->isValid()) {
            return false;
        }

        /** @var EntryEntity $entry */
        $entry = $this->entryForm->getData();

        $this->eventManager->trigger(__FUNCTION__ . '.pre', $this, array('entry' => $entry));
        $this->entryMapper->insert($this->entryForm->getData());
        $this->eventManager->trigger(__FUNCTION__ . '.post', $this, array('entry' => $entry));

        return $entry;
    }

    /**
     * Retrieve all entries in the Guestbook
     *
     * @return null|\Zend\Db\ResultSet\ResultSetInterface
     */
    public function findAll()
    {
        return $this->entryMapper->findAll();
    }

    /**
     * Retrieve the event manager
     *
     * Lazy-loads an EventManager instance if none registered.
     *
     * @return EventManagerInterface
     */
    public function getEventManager()
    {
        return $this->eventManager;
    }
}
