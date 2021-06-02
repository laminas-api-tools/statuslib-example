<?php

/**
 * @see       https://github.com/laminas-api-tools/statuslib-example for the canonical source repository
 * @copyright https://github.com/laminas-api-tools/statuslib-example/blob/master/COPYRIGHT.md
 * @license   https://github.com/laminas-api-tools/statuslib-example/blob/master/LICENSE.md New BSD License
 */

namespace StatusLib;

use stdClass;
use Traversable;

/**
 * Interface for StatusLib mappers
 */
interface MapperInterface
{
    /**
     * @param array|Traversable|stdClass $data
     * @return Entity
     */
    public function create($data);

    /**
     * @param string $id
     * @return Entity
     */
    public function fetch($id);

    /**
     * @return Collection
     */
    public function fetchAll();

    /**
     * @param string $id
     * @param array|Traversable|stdClass $data
     * @return Entity
     */
    public function update($id, $data);

    /**
     * @param string $id
     * @return bool
     */
    public function delete($id);
}
