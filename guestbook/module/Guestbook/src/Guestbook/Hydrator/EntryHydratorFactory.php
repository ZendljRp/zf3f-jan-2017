<?php

namespace Guestbook\Hydrator;

use Zend\Hydrator\NamingStrategy\MapNamingStrategy;
use Zend\Hydrator\NamingStrategyEnabledInterface;

/**
 * Class EntryHydratorFactory
 * @package Guestbook\Hydrator
 */
class EntryHydratorFactory
{
    /**
     * EntryHydratorFactory constructor.
     * @param NamingStrategyEnabledInterface $hydrator
     * @param array $mapping
     */
    public function __construct(NamingStrategyEnabledInterface $hydrator, array $mapping)
    {
        $hydrator->setNamingStrategy(new MapNamingStrategy($mapping));

        return $hydrator;
    }
}
