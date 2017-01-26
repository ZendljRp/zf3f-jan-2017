<?php
return array(
	'service_manager' => array(
		'services' => array(
		    'market-max-attempts' => 3,
		    'market-expire-days' => array(
		        0  => 'Never',
		        1  => 'Tomorrow',
		        7  => 'Week',
		        30 => 'Month',
		    ),
			'market-captcha-options' => array(
		    	'expiration' => 300,
		    	'font'		=> '/usr/share/fonts/truetype/freefont/FreeSansBold.ttf',
		    	'fontSize'	=> 24,
		    	'height'	=> 50,
		    	'width'		=> 200,
		    	'imgDir'	=> __DIR__ . '/../../../public/captcha',
		    	'imgUrl'	=> '/captcha',
		    ),
		),
	    'invokables' => array(
	        'market-delete-form'   => 'Market\Form\DeleteForm',
	        'market-delete-filter' => 'Market\Form\DeleteFormFilter',
		),
		'factories' => array(
			'market-post-form'     => 'Market\Factory\PostFormFactory',
			'market-post-filter'   => 'Market\Factory\PostFilterFactory',
		    'listings-table'       => 'Market\Factory\ListingsTableFactory',
		    'city-codes-table'     => 'Market\Factory\CityCodesTableFactory',
		),
	),
    'controllers' => array(
    	'aliases' => array(
    		'alt' => 'market-view-controller',
    	),
        'invokables' => array(
            'market-city-controller' => 'Market\Controller\CityCodesController',
        ),
    	'factories' => array(
            'market-index-controller'  => 'Market\Factory\IndexControllerFactory',
            'market-view-controller'   => 'Market\Factory\ViewControllerFactory',
            'market-post-controller'   => 'Market\Factory\PostControllerFactory',
            'market-delete-controller' => 'Market\Factory\DeleteControllerFactory',
    	),
    ),
    'router' => array(
        'routes' => array(
        	'home' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/',
                    'defaults' => array(
                        'controller'    => 'market-index-controller',
                        'action'        => 'index',
                    ),
                ),
        	),
        	'city-lookup' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/city-lookup',
                    'defaults' => array(
                        'controller'    => 'market-city-controller',
                        'action'        => 'lookup',
                    ),
                ),
        	),
            'market' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/market',
                    'defaults' => array(
                        'controller'    => 'market-index-controller',
                        'action'        => 'index',
                        'module'        => 'market',
                    ),
                ),
        		'may_terminate' => TRUE,
        		'child_routes' => array(
		        	'slash' => array(
		                'type'    => 'Literal',
		                'options' => array(
		                    'route'    => '/',
		                    'defaults' => array(
		                        'action' => 'index',
		                    ),
		                ),
		        	),
        		    'foo' => array(
		                'type'    => 'Segment',
		                'options' => array(
		                    'route'    => '/foo[/]',
		                    'defaults' => array(
		                        'action'        => 'foo',
		                    ),
		                ),
		        	),
        		    'view' => array(
		                'type'    => 'Literal',
		                'options' => array(
		                    'route'    => '/view',
		                    'defaults' => array(
		                        'controller' => 'market-view-controller',
		                        'action'     => 'index',
		        			    'category'   => 'free',
		                    ),
		                ),
		        		'may_terminate' => TRUE,
		        		'child_routes' => array(
		        			'main' => array(
		        				'type' => 'Segment',
		        				'options' => array(
		        					'route' => '/main[/:category]',
		        					'defaults' => array(
		        					    'category' => 'free',
		        					),
		        				    'constraints' => array(
		        				        'category' => '[a-zA-Z 0-9]*',
		        				    ),
		        				),
		        			),
		        			'item' => array(
		        				'type' => 'Segment',
		        				'options' => array(
		        					'route' => '/item[/:itemId][/:test]',
		        					'defaults' => array(
		                        		'action' => 'item',
		        					    'test' => 200,
		        					    'itemId' => 1,
		        					),
		        					'constraints' => array(
		        						'itemId' => '[0-9]*',
		        					),
		        				),
		        			),
		        		),
		        	),
		        	'post' => array(
		                'type'    => 'Segment',
		                'options' => array(
		                    'route'    => '/post[/]',
		                    'defaults' => array(
		                        'controller'    => 'market-post-controller',
		                        'action'        => 'index',
		                    ),
		                ),
	        	    ),
                    'delete' => array(
                        'type'    => 'Literal',
                        'options' => array(
                            'route'    => '/delete',
                            'defaults' => array(
                                'controller'    => 'market-delete-controller',
                                'action'        => 'index',
                            ),
                        ),
                        'may_terminate' => true,
                        'child_routes' => array(
                            'id' => array(
                                'type'    => 'Segment',
                                'options' => array(
                                    'route'    => '[/:id][/]',
                                    'constraints' => array(
                                        'id'     => '[0-9]*',
                                    ),
                                ),
                            ),
                            'confirm' => array(
                                'type'    => 'Segment',
                                'options' => array(
                                    'route'    => '/confirm',
                                    'defaults' => array(
                                        'controller'    => 'market-delete-controller',
                                        'action'        => 'deleteConfirm',
                                    ),
                                ),
                            ),
                        ),
                    ),
        		),
        	),
        ),
    ), 
    'view_manager' => array(
        'template_path_stack' => array(
            'Market' => __DIR__ . '/../view',
        ),
    ),
);
