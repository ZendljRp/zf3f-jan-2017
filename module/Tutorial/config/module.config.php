<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Tutorial;

use Zend\Router\Http\Literal;
use Zend\Router\Http\Segment;
use Zend\ServiceManager\Factory\InvokableFactory;
use Zend\Form\Element;
use Zend\Hydrator\ArraySerializable;

return [
    'router' => [
        'routes' => [
            'tutorial' => [
                'type' => Segment::class,
                'options' => [
                    'route'    => '/tutorial[/:firstName][/:lastName]',
                    'defaults' => [
                        'controller' => Controller\IndexController::class,
                        'action'     => 'index',
                    ],
                    'constraints' => [
                        'firstName' => '[a-zA-Z0-9_-]+',
                        'lastName' => '[a-zA-Z0-9_-]+',
                    ],
                ],
            ],
            'tutorial-google' => [
                'type' => Literal::class,
                'options' => [
                    'route'    => '/google',
                    'defaults' => [
                        'controller' => Controller\IndexController::class,
                        'action'     => 'google',
                    ],
                ],
            ],
            'tutorial-home' => [
                'type' => Literal::class,
                'options' => [
                    'route'    => '/tutorial/home',
                    'defaults' => [
                        'controller' => Controller\IndexController::class,
                        'action'     => 'home',
                        'config'     => __FILE__
                    ],
                ],
            ],
            'tutorial-info' => [
                'type' => Segment::class,
                'options' => [
                    'route'    => '/tutorial/info[/:infoKey]',
                    'defaults' => [
                        'controller' => Controller\InfoController::class,
                        'action'     => 'index',
                    ],
                    'constraints' => [
                        'infoKey' => '[A-Za-z]+'
                    ]
                ],
            ],
        ],
    ],
    'controllers' => [
        'factories' => [
            Controller\IndexController::class => InvokableFactory::class,
            Controller\InfoController::class => Controller\Factory\InfoControllerFactory::class,
        ],
    ],
    'view_manager' => [
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
        /*
        'template_map' => [
            'tutorial/index/index' => __DIR__ . '/../view/tutorial/index/index.phtml',
        ],
        */
    ],
    'service_manager' => [
        'services' => [
            'tutorial-info-config' => [
                'google' => ['website' => 'http://google.com/', 'owner' => 'Eric Schmidt', 'notes' => 'Search'],
                'unlikelysource' => ['website' => 'http://unlikelysource.com/', 'owner' => 'Doug Bierer', 'notes' => 'PHP Stuff'],
            ]
            'tutorial-form-config' => [
                'hydrator' => ArraySerializable::class,
                'elements' => [
                    [
                        'spec' => [
                            'name' => 'name',
                            'options' => [
                                'label' => 'Your name',
                            ],
                            'type'  => 'Text',
                        ],
                    ],
                    [
                        'spec' => [
                            'type' => Element\Email::class,
                            'name' => 'email',
                            'options' => [
                                'label' => 'Your email address',
                            ]
                        ],
                    ],
                    [
                        'spec' => [
                            'name' => 'send',
                            'type'  => 'Submit',
                            'attributes' => [
                                'value' => 'Submit',
                            ],
                        ],
                    ],
                ],

                // Configuration to pass on to
                // Zend\InputFilter\Factory::createInputFilter()
                'input_filter' => [
                    'name' => [
                        [
                            'name' => 'name',
                            'required' => true,
                            'filters' => [
                                [
                                    'name' => 'Zend\Filter\StringTrim',
                                    'options' => [],
                                ],
                                [
                                    'name' => 'Zend\Filter\StripTags',
                                    'options' => [],
                                ],
                            ],
                            'validators' => [
                                [
                                    'name' => 'Zend\I18n\Validator\Alnum',
                                    'options' => [],
                                ],
                            ],
                            'description' => 'Member Name',
                            'allow_empty' => false,
                            'continue_if_empty' => false,
                        ],
                    ],
                    'email' => [
                        [
                            'name' => 'email',
                            'required' => true,
                            'filters' => [
                                [
                                    'name' => 'Zend\Filter\StringTrim',
                                    'options' => [],
                                ],
                                [
                                    'name' => 'Zend\Filter\StripTags',
                                    'options' => [],
                                ],
                            ],
                            'validators' => [
                                [
                                    'name' => 'Zend\Validator\EmailAddress',
                                    'options' => [],
                                ],
                            ],
                            'description' => 'Email Address',
                            'allow_empty' => false,
                            'continue_if_empty' => false,
                        ],
                    ],
                ],
            ],
        ],
        'factories' => [
            'tutorial-info-list' => Model\Factory\InfoFactory::class // some factory class
            'tutorial-form' => Form\Factory\FormFactory::class // some factory class
        ],
    ]
];
