<?php
namespace Market\Model;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Where;
class CityCodesTable extends TableGateway
{
	const TABLE_NAME = 'world_city_area_codes';
	public function getTableName()
	{
		return self::TABLE_NAME;
	}
    /**
     * Returns an associative array: key = id => value = name of city
     * @param string $city
     * @return Array $cityCodes
     */
    public function getAllCityCodesForForm($city = '')
    {
    	$cityCodesForForm = array();
    	$select = new Select();
    	$select->from($this->getTableName());
    	$select->order('city ASC');
    	$where = new Where();
    	$where->isNotNull('city');
    	if ($city) {
    	    $where->like('city', '%' . $city . '%');
    	}
    	$select->where($where);
    	$cityCodesAll = $this->selectWith($select);
    	foreach ($cityCodesAll as $city) {
    		if (strlen($city->city) > 1) {
    		    // appends city name + ISO2 country code to array
    			$cityCodesForForm[$city->world_city_area_code_id] = $city->city . ', ' . $city->ISO2;
    		}
    	}
    	return $cityCodesForForm;
    }
}
