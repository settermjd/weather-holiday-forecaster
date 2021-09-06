<?php

declare(strict_types=1);

use Doctrine\Common\Persistence\Mapping\Driver\MappingDriverChain;
use Doctrine\ORM\Mapping\Driver\AnnotationDriver;

return [
    'doctrine' => [
        'connection' => [
            'orm_default' => [
                'params' => [
                    'url' => 'sqlite:////' . __DIR__ . '/../../data/database.db',
                ],
            ],
        ],
        'driver' => [
            'orm_default' => [
                'class' => MappingDriverChain::class,
                'drivers' => [
                    'App\Entity' => 'my_entity',
                ],
            ],
            'my_entity' => [
                'class' => AnnotationDriver::class,
                'cache' => 'array',
                'paths' => __DIR__.'/../../src/App/src/Entity',
            ],
        ],
    ],
];

