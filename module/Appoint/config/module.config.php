<?php

namespace Appoint;

use Zend\Router\Http\Segment;
#use Zend\ServiceManager\Factory\InvokableFactory;

return [
    #'controllers' => [
        #'factories' => [
            #Controller\AppointController::class => InvokableFactory::class,
        #],
   # ],

    // The following section is new and should be added to your file:
    'router' => [
        'routes' => [
            'appoint' => [
                'type'    => Segment::class,
                'options' => [
                    'route' => '/appoint[/:action[/:id]]',
                    'constraints' => [
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ],
                    'defaults' => [
                        'controller' => Controller\AppointController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
        ],
    ],

    'view_manager' => [
        'template_path_stack' => [
            'appoint' => __DIR__ . '/../view',
        ],
    ],
];