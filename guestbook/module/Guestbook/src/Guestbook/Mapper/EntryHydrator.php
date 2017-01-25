<?php
namespace Guestbook\Mapper;

use Zend\Hydrator\HydratorInterface;

/**
 * Class EntryHydrator
 * @package Guestbook\Mapper
 */
class EntryHydrator implements HydratorInterface
{
    /**
     * @param object $object
     * @return array
     */
    public function extract($object)
    {
        return [
            'entry_id'      => $object->getId(),
            'entry_name'    => $object->getName(),
            'entry_email'   => $object->getEmail(),
            'entry_website' => $object->getWebsite(),
            'entry_message' => $object->getMessage(),
        ];
    }

    /**
     * @param array $data
     * @param object $object
     * @return object
     */
    public function hydrate(array $data, $object)
    {
        $object->setId($data['entry_id'])
               ->setName($data['entry_name'])
               ->setEmail($data['entry_email'])
               ->setWebsite($data['entry_website'])
               ->setMessage($data['entry_message']);

        return $object;
    }
}
