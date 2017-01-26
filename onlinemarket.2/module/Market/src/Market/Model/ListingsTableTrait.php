<?php
namespace Market\Model;

trait ListingsTableTrait
{
    protected $listingsTable;
    
	/**
	 * @return the $listingsTable
	 */
	public function getListingsTable() {
		return $this->listingsTable;
	}

	/**
	 * @param field_type $listingsTable
	 */
	public function setListingsTable($listingsTable) {
		$this->listingsTable = $listingsTable;
	}
    
}