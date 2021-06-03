<?php

declare(strict_types=1);

namespace StatusLib;

return [
    'statuslib'       => [
        // 'array_mapper_path' => 'path/to/PHP/file/returning/array.php',
    ],
    'service_manager' => [
        'aliases'   => [
            Mapper::class => ArrayMapper::class,

            // Legacy Zend Framework aliases
        ],
        'factories' => [
            ArrayMapper::class        => ArrayMapperFactory::class,
            TableGatewayMapper::class => TableGatewayMapperFactory::class,
            TableGateway::class       => TableGatewayFactory::class,
        ],
    ],
];
