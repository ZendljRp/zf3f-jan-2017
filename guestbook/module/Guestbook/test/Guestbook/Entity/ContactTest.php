<?php

namespace GuestbookTest\Form;


use Guestbook\Entity\Contact;
use Zend\Form\Annotation\AnnotationBuilder;

/**
 * Class ContactTest
 * @package GuestbookTest\Entity
 */
class ContactTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Contact
     */
    private $form;

    public function setUp()
    {
        $this->form = new Contact();
    }

    /**
     * @dataProvider formDataProvider
     */
    public function testFormFiltersCorrectly($original, $filtered)
    {
        $form = (new AnnotationBuilder())
            ->createForm(new Contact());

        $form->setData($original);
        $form->isValid();
        $filteredData = $form->getData();

        $this->assertSame($filteredData['name'], $filtered['name']);
    }

    public function formDataProvider()
    {
        return [
            [
                [
                    'name' => '   Matthew    ',
                    'email' => 'matthew@example.com',
                    'message' => 'Here is my message'
                ],
                [
                    'name' => 'Matthew',
                    'email' => 'matthew@example.com',
                    'message' => 'Here is my message'
                ]
            ]
        ];
    }
}
