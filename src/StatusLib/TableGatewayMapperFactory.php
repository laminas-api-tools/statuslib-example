<?php

/**
 * @see       https://github.com/laminas-api-tools/statuslib-example for the canonical source repository
 * @copyright https://github.com/laminas-api-tools/statuslib-example/blob/master/COPYRIGHT.md
 * @license   https://github.com/laminas-api-tools/statuslib-example/blob/master/LICENSE.md New BSD License
 */

namespace StatusLib;

use DomainException;

/**
 * Service factory for returning a StatusLib\TableGatewayMapper instance.
 *
 * Requires the StatusLib\TableGateway service be present in the service locator.
 */
class TableGatewayMapperFactory
{
    public function __invoke($services)
    {
        if (!$services->has('StatusLib\TableGateway')) {
            throw new DomainException('Cannot create StatusLib\TableGatewayMapper; missing StatusLib\TableGateway dependency');
        }
        return new TableGatewayMapper($services->get('StatusLib\TableGateway'));
    }
}
