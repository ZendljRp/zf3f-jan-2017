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
        ],
    ],
    'controllers' => [
        'factories' => [
            Controller\IndexController::class => InvokableFactory::class,
        ],
    ],
    'view_manager' => [
        /*
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
        */
        'template_map' => [
            'tutorial/index/index' => __DIR__ . '/../view/tutorial/index/index.phtml',
        ],
    ],
];
