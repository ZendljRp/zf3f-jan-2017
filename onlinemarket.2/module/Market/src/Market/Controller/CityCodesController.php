<?php
namespace Market\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\JsonModel;

class CityCodesController extends AbstractActionController
{

    public function lookupAction()
    {
        $cityCodesTable = $this->getServiceLocator()->get('city-codes-table');
        $city = $this->params()->fromQuery('term');
        $result = $cityCodesTable->getAllCityCodesForForm($city);
        $jsonModel = new JsonModel($result);
        return $jsonModel;        
    }
}
