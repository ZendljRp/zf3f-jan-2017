<?php

namespace Guestbook\TableGateway;

use Guestbook\Entity\Entry;
use Interop\Container\ContainerInterface;
use Zend\Db\Adapter\Adapter;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Db\TableGateway\TableGateway;
use Zend\Hydrator\ClassMethods;
use Zend\Hydrator\NamingStrategy\MapNamingStrategy;
use Zend\ServiceManager\Factory\FactoryInterface;

/**
 * Class EntryTableGatewayFactory
 * @package Guestbook\TableGateway
 */
class EntryTableGatewayFactory implements FactoryInterface
{
    /**
     * @param ContainerInterface $container
     * @param string $requestedName
     * @param array|null $options
     * @return TableGateway
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $hydrator = new ClassMethods();
        $hydrator->setNamingStrategy(
            // Map the columns in the database table
            // to the member variables in the entity object
            new MapNamingStrategy(
                [
                    'entry_id' => 'id',
                    'entry_name' => 'name',
                    'entry_email' => 'email',
                    'entry_website' => 'website',
                    'entry_message' => 'message',
                ]
            )
        );

        return new TableGateway(
            'guestbook_entry',
            $container->get(Adapter::class),
            null,
            new HydratingResultSet($hydrator, $container->get(Entry::class))
        );
    }
}
