<?php

declare(strict_types=1);

namespace StatusLib;

use DomainException;
use Psr\Container\ContainerInterface;
use StatusLib\TableGateway;

use function sprintf;

/**
 * Service factory for returning a StatusLib\TableGatewayMapper instance.
 *
 * Requires the StatusLib\TableGateway service be present in the service locator.
 */
class TableGatewayMapperFactory
{
    /**
     * @param ContainerInterface $services
     * @return TableGatewayMapper
     */
    public function __invoke($services)
    {
        if (! $services->has(TableGateway::class)) {
            throw new DomainException(sprintf(
                'Cannot create %s; missing %s dependency',
                TableGatewayMapper::class,
                TableGateway::class
            ));
        }
        return new TableGatewayMapper($services->get(TableGateway::class));
    }
}
