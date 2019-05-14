<?php

namespace Appoint;

use Zend\Router\Http\Segment;

return [

    // Mapping URL to a particular action (add, edit delete) is done using routes
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