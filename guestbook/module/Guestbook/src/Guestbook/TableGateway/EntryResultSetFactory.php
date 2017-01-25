<?php

namespace Guestbook\TableGateway;

use Guestbook\Entity\Entry;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Hydrator\HydratorInterface;

/**
 * Class EntryResultSetFactory
 * @package Guestbook\TableGateway
 */
class EntryResultSetFactory
{
    /**
     * EntryResultSetFactory constructor.
     * @param HydratorInterface $hydrator
     * @param Entry $entry
     */
    public function __construct(HydratorInterface $hydrator, Entry $entry)
    {
        return new HydratingResultSet($hydrator, $entry);
    }
}
