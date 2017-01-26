<?php
namespace Market\Model;

trait CityCodesTableTrait
{
    protected $cityCodesTable;
    
	/**
	 * @return the $cityCodesTable
	 */
	public function getCityCodesTable() {
		return $this->cityCodesTable;
	}

	/**
	 * @param field_type $cityCodesTable
	 */
	public function setCityCodesTable($cityCodesTable) {
		$this->cityCodesTable = $cityCodesTable;
	}
    
}