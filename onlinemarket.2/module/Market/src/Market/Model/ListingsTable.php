<?php
namespace Market\Model;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Select;
class ListingsTable extends TableGateway
{
	const TABLE_NAME = 'listings';   // suggested by Ludo
	public function getTableName()
	{
		return self::TABLE_NAME;
	}
	public function getListingsByCategory($category)
	{
		return $this->select(array('category' => $category));
	}
	public function getListingById($id)
	{
		return $this->select(array('listings_id' => $id))->current();
	}
	// SELECT * FROM `listings` WHERE `listings_id` IN (SELECT MAX(`listings_id`) FROM `listings`)
	public function getLatestListing()
	{
		$select = new Select();
		$select->from($this->getTableName())
		->order('listings_id DESC')
		->limit(1);
		return $this->selectWith($select)->current();
	}
	public function saveData($data)
	{
		// extract city and country
		list($city, $country) = explode(',', $data['cityCode']);
		$data['city'] = trim($city);
		$data['country'] = trim($country);
		// calcuate expiration date
		$date = new \DateTime();
		// add <expire> days (i.e. 1 week) to today
		if ($data['expires']) {
		    if ($data['expires'] == 30) {
			    $date->add(new \DateInterval('P1M'));
		    } else {
		        $date->add(new \DateInterval('P' . $data['expires'] . 'D'));
		    }
		}
		$data['date_expires'] = $date->format('Y-m-d H:i:s');
		unset($data['cityCode'], $data['expires'], $data['captcha'], $data['submit']);
		$this->insert($data);
	}
}
