<?php
namespace Guestbook\Form;

use Zend\Form\Form;
use Zend\Hydrator\ClassMethods;
use Zend\Hydrator\HydratorInterface;
use Zend\InputFilter\InputFilterInterface;

/**
 * Class Entry
 * @package Guestbook\Form
 */
class Entry extends Form
{
    /**
     * Entry constructor.
     * @param HydratorInterface $hydrator
     * @param InputFilterInterface $inputFilter
     */
    public function __construct(InputFilterInterface $inputFilter)
    {
        parent::__construct();

        $this->add([
            'name' => 'name',
            'options' => [
                'label' => 'Name',
            ],
            'attributes' => [
                'class' => 'form-control',
                'type' => 'text'
            ],
        ]);

        $this->add([
            'name' => 'email',
            'options' => [
                'label' => 'Email',
            ],
            'attributes' => [
                'class' => 'form-control',
                'type' => 'email'
            ],
        ]);

        $this->add([
            'name' => 'website',
            'options' => [
                'label' => 'Website',
            ],
            'attributes' => [
                'class' => 'form-control',
                'type' => 'url'
            ],
        ]);

        $this->add([
            'name' => 'message',
            'options' => [
                'label' => 'Message',
            ],
            'attributes' => [
                'class' => 'form-control',
                'type' => 'textarea'
            ],
        ]);

        $this->add([
            'name' => 'submit',
            'attributes' => [
                'class' => 'btn btn-primary btn-lg btn-block',
                'type' => 'submit',
                'value' => 'Submit'
            ],
        ]);

        $this->setHydrator(new ClassMethods());
        $this->setInputFilter($inputFilter);
    }
}
