<?php

/**
 * @see       https://github.com/laminas-api-tools/statuslib-example for the canonical source repository
 * @copyright https://github.com/laminas-api-tools/statuslib-example/blob/master/COPYRIGHT.md
 * @license   https://github.com/laminas-api-tools/statuslib-example/blob/master/LICENSE.md New BSD License
 */

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
