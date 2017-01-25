<?php
namespace Guestbook\Mapper;

use \Guestbook\Entity\Entry as EntryEntity;
use Zend\Db\TableGateway\TableGateway;

/**
 * Class Entry
 * @package Guestbook\Mapper
 */
class Entry
{
    /**
     * @var TableGateway
     */
    protected $tableGateway;

    /**
     * Entry constructor.
     * @param TableGateway $tableGateway
     */
    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    /**
     * @param EntryEntity $entity
     * @return EntryEntity
     */
    public function insert(EntryEntity $entity)
    {
        $result = $this->tableGateway->insert([
            'entry_id' => $entity->getId(),
            'entry_name' => $entity->getName(),
            'entry_email' => $entity->getEmail(),
            'entry_website' => $entity->getWebsite(),
            'entry_message' => $entity->getMessage(),
        ]);
        $entity->setId($result);

        return $entity;
    }

    /**
     * @return null|\Zend\Db\ResultSet\ResultSetInterface
     */
    public function findAll()
    {
        return $this->tableGateway
            ->selectWith($this->tableGateway
                ->getSql()
                ->select()
                ->order('entry_id'));
    }
}
