<?php
use Guestbook\Controller\IndexController;
use Guestbook\Form\Entry as EntryForm;
use Guestbook\Form\EntryFilter;
use Guestbook\Mapper\Entry as EntryMapper;
use Guestbook\Service\Entry as EntryService;
use Guestbook\Service\HtmlTableRowHelper;
use Guestbook\TableGateway\EntryTableGatewayFactory;
use Zend\Db\Adapter\Adapter;
use Zend\EventManager\EventManagerInterface;
use Zend\ServiceManager\AbstractFactory\ConfigAbstractFactory;

return [
    'router' => [
        'routes' => [
            'guestbook' => [
                'type' => 'literal',
                'options' => [
                    'route' => '/guestbook',
                    'defaults' => [
                        'controller' => IndexController::class,
                        'action' => 'index',
                    ],
                ],
            ],
        ],
    ],
    'controllers' => [
        'factories' => [
            IndexController::class => ConfigAbstractFactory::class,
        ],
    ],
    'view_manager' => [
        'template_path_stack' => [
            'guestbook' => __DIR__ . '/../view',
        ],
    ],
    'view_helpers' => [
        'invokables' => [
            'htmlTableRow' => HtmlTableRowHelper::class,
        ],
    ],
    'service_manager' => [
        'abstract_factories' => [
            ConfigAbstractFactory::class,
        ],
        'factories' => [
            'EventTableGateway' => EntryTableGatewayFactory::class
        ]
    ],

    /**
     * Provide the configuration for factories which use the ConfigAbstractFactory
     */
    ConfigAbstractFactory::class => [
        EntryForm::class => [
            EntryFilter::class
        ],
        EntryMapper::class => [
            'EventTableGateway'
        ],
        EntryService::class => [
            EntryForm::class,
            EntryMapper::class,
            EventManagerInterface::class
        ],
        EntryTableGatewayFactory::class => [
            Adapter::class,
            \Guestbook\Entity\Entry::class
        ],
        IndexController::class => [
            EntryForm::class,
            EntryService::class
        ]
    ],
];
