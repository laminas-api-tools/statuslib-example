<?php

/**
 * @see       https://github.com/laminas-api-tools/statuslib-example for the canonical source repository
 * @copyright https://github.com/laminas-api-tools/statuslib-example/blob/master/COPYRIGHT.md
 * @license   https://github.com/laminas-api-tools/statuslib-example/blob/master/LICENSE.md New BSD License
 */

return array(
    'statuslib' => array(
        // 'array_mapper_path' => 'path/to/PHP/file/returning/array.php',
    ),
    'service_manager' => array(
        'aliases' => array(
            'StatusLib\Mapper' => 'StatusLib\ArrayMapper',
        ),
        'factories' => array(
            'StatusLib\ArrayMapper'        => 'StatusLib\ArrayMapperFactory',
            'StatusLib\TableGatewayMapper' => 'StatusLib\TableGatewayMapperFactory',
            'StatusLib\TableGateway'       => 'StatusLib\TableGatewayFactory',
        ),
    ),
);
