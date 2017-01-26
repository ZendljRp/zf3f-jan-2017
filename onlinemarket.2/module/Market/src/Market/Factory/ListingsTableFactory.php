<?php
namespace Market\Factory;
use Market\Model\ListingsTable;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
class ListingsTableFactory implements FactoryInterface
{
	public function createService(ServiceLocatorInterface $sm)
	{
		return new ListingsTable(ListingsTable::TABLE_NAME, $sm->get('general-adapter'));
	}
}
