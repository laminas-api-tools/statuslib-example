<?php

/**
 * @see       https://github.com/laminas-api-tools/statuslib-example for the canonical source repository
 * @copyright https://github.com/laminas-api-tools/statuslib-example/blob/master/COPYRIGHT.md
 * @license   https://github.com/laminas-api-tools/statuslib-example/blob/master/LICENSE.md New BSD License
 */

namespace StatusLib;

use DomainException;

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
    public function __invoke($services)
    {
        $db    = 'Db\StatusLib';
        $table = 'status';
        if ($services->has('config')) {
            $config = $services->get('config');
            switch (isset($config['statuslib'])) {
                case true:
                    $config = $config['statuslib'];
                    $db     = isset($config['db']) ? $config['db'] : $db;
                    $table  = isset($config['table']) ? $config['table'] : $table;
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
