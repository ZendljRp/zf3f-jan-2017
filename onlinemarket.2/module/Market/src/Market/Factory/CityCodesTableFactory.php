<?php
namespace Market\Factory;
use Market\Model\CityCodesTable;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
class CityCodesTableFactory implements FactoryInterface
{
	public function createService(ServiceLocatorInterface $sm)
	{
		return new CityCodesTable(CityCodesTable::TABLE_NAME, $sm->get('general-adapter'));
	}
}
