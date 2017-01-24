<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Tutorial\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class InfoController extends AbstractActionController
{
    protected $infoItems;
    protected $form;
    public function indexAction()
    {
        $infoKey = $this->params()->fromRoute('infoKey');
        return new ViewModel(['infoKey' => $infoKey, 'infoItems' => $this->getInfoItems()]);
    }
    public function formAction()
    {
        return new ViewModel(['form' => $this->form]);
    }
    public function setInfoItems($infoItems)
    {
        $this->infoItems = $infoItems;
    }
    public function getInfoItems()
    {
        return $this->infoItems;
    }
}
