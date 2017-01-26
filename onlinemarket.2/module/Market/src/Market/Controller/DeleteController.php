<?php
namespace Market\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Market\Model\ListingsTable;
use Market\Form\DeleteForm;
use Market\Form\DeleteFormFilter;

class DeleteController extends AbstractActionController
{
	protected $listingsTable;
	protected $deleteForm;	
	protected $deleteFormFilter;	
	
    public function indexAction()
    {
    	// get listings ID param
    	$id = (int) $this->params()->fromRoute('id');
    	// pull info from table
    	$item = $this->listingsTable->getListingById($id);
    	// if no results go home
    	if (!$item) {
    		$this->flashMessenger()->addMessage('Unable to delete this item');
    		return $this->redirect()->toRoute('home');
    	}
    	// otherwise prepare form
    	$this->deleteForm->prepareElements($id);
    	$this->deleteForm->setAttribute('action', $this->url()->fromRoute('market/delete/confirm'));
		$this->deleteForm->get('id')->setAttribute('value', $id);
    	// render view
	    return new ViewModel(array('item' 		=> $item,
	    						   'deleteForm' => $this->deleteForm,
	    						   'id'			=> $id));
    }
    
    public function deleteConfirmAction()
    {
    	$deleted = FALSE;
    	// retrieve $_POST data
    	$data = $this->params()->fromPost();
    	// check to see if submit button pressed
    	if (isset($data['cancel'])) {
    	    $this->flashMessenger()->addMessage('Delete cancelled');
    	    return $this->redirect()->toRoute('home');
    	}    	
    	if (isset($data['submit'])) {    	
    		// prepare filters
    		$this->deleteFormFilter->prepareFilters();
    		$this->deleteFormFilter->setData($data);
    		// validate data against the filter
    		if ($this->deleteFormFilter->isValid($data)) {
    			// get valid data
    			$validData = $this->deleteFormFilter->getValues();
		    	// pull info from table
		    	$item = $this->listingsTable->getListingById($validData['id']);    			
    			// check delete code
    			if ($item && ($validData['delCode'] == $item->delete_code)) {
    				// delete item
    				if ($this->listingsTable->delete(array('listings_id' => $validData['id']))) {
	    				// set flag
	    				$deleted = TRUE;
    				}
    			}
    		}
    	}
    	// messages
    	if ($deleted) {
    		$this->flashMessenger()->addMessage('Item Successfully Deleted');
    	} else {
    		$this->flashMessenger()->addMessage('Sorry! Unable to Delete Item.');
    	}
    	return $this->redirect()->toRoute('home');
    }
    
    // called by DeleteControllerFactory
    public function setListingsTable(ListingsTable $table)
    {
    	$this->listingsTable = $table;
    }
    
    // called by DeleteControllerFactory
    public function setDeleteForm(DeleteForm $form)
    {
    	$this->deleteForm = $form;
    }
    
    // called by DeleteControllerFactory
    public function setDeleteFormFilter(DeleteFormFilter $filter)
    {
    	$this->deleteFormFilter = $filter;
    }

}

