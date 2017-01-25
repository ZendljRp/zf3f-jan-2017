<?php
namespace Guestbook\Form;

use Zend\Filter\StringTrim;
use Zend\Filter\UriNormalize;
use Zend\InputFilter\InputFilter;
use Zend\Validator\EmailAddress;
use Zend\Validator\NotEmpty;
use Zend\Validator\StringLength;
use Zend\Validator\Uri;

/**
 * Class EntryFilter
 * @package Guestbook\Form
 */
class EntryFilter extends InputFilter
{
    /**
     * EntryFilter constructor.
     */
    public function __construct()
    {
        $this->add([
            'name' => 'name',
            'required' => true,
            'filters' => [
                [
                    'name' => StringTrim::class
                ]
            ],
            'validators' => [
                [
                    'name' => StringLength::class,
                    'options' => [
                        'min' => 1,
                        'max' => 255,
                    ],
                ],
            ],
        ]);

        $this->add([
            'name' => 'email',
            'required' => true,
            'filters' => [
                [
                    'name' => StringTrim::class
                ]
            ],
            'validators' => [
                [
                    'name' => EmailAddress::class
                ]
            ],
        ]);

        // tag::add-website-element[]
        $this->add([
            'name' => 'website', // <1>
            'required' => true,
            'filters' => [
                ['name' => StringTrim::class],
                [
                    'name' => UriNormalize::class,
                    'options' => [
                        'enforcedscheme' => 'http' // <2>
                    ]
                ]
            ],
            'validators' => [
                [
                    'name' => Uri::class
                ]
            ],
        ]);
        // end::add-website-element[]

        $this->add([
            'name' => 'message',
            'required' => true,
            'filters' => [
                [
                    'name' => StringTrim::class
                ]
            ],
            'validators' => [
                [
                    'name' => NotEmpty::class
                ],
            ],
        ]);
    }
}
