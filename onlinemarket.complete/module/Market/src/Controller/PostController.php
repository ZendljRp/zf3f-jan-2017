<?php
namespace Market\Controller;

use Zend\View\Model\ViewModel;
use Zend\Mvc\Controller\AbstractActionController;

class PostController extends AbstractActionController
{

    const ERROR_POST = 'ERROR: unable to validate item information';
    const ERROR_SAVE = 'ERROR: unable to save item to the database';
    const SUCCESS_POST = 'SUCCESS: item posted OK';

    use FlashTrait;
    use PostFormTrait;
    use ListingsTableTrait;

    public function indexAction()
    {
        $data = [];
        if ($this->getRequest()->isPost()) {
            $data = $this->params()->fromPost();
            $this->breakoutCityAndCountry($data);
            $this->postForm->setData($data);
            if ($this->postForm->isValid()) {
                if ($this->listingsTable->save($this->postForm->getData())) {
                    $this->flash->addMessage(self::SUCCESS_POST);
                    return $this->redirect()->toRoute('market');
                } else {
                    $this->flash->addMessage(self::ERROR_SAVE);
                }
            } else {
                $this->flash->addMessage(self::ERROR_POST);
            }
        }
        return new ViewModel(['postForm' => $this->postForm, 'data' => $data, 'flash' => $this->flash]);
    }

    protected function breakoutCityAndCountry(&$data)
    {
        if (isset($data['cityCode']) && strpos($data['cityCode'], ','))
            list($data['city'],$data['country']) = explode(',', $data['cityCode']);
    }

}
