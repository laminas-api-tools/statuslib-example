<?php

declare(strict_types=1);

namespace StatusLib;

use DomainException;
use Psr\Container\ContainerInterface;

use function sprintf;

/**
 * Service factory for the StatusLib TableGateway
 *
 * If the "statuslib" key is present, and either the "db" or "table" subkeys
 * are present and valid, uses those; otherwise, uses defaults of "Db\StatusLib"
 * and "status", respectively.
 *
 * If the DB service does not exist, raises an error.
 *
 * Otherwise, creates a TableGateway instance with the DB service and table.
 */
class TableGatewayFactory
{
    /**
     * @param ContainerInterface $services
     * @return TableGateway
     */
    public function __invoke($services)
    {
        $db    = 'Db\StatusLib';
        $table = 'status';
        if ($services->has('config')) {
            $config = $services->get('config');
            switch (isset($config['statuslib'])) {
                case true:
                    $config = $config['statuslib'];
                    $db     = $config['db'] ?? $db;
                    $table  = $config['table'] ?? $table;
                    break;
                case false:
                default:
                    break;
            }
        }

        if (! $services->has($db)) {
            throw new DomainException(sprintf(
                'Unable to create %s due to missing "%s" service',
                TableGateway::class,
                $db
            ));
        }

        return new TableGateway($table, $services->get($db));
    }
}
