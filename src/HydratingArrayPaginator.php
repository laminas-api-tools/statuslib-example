<?php

declare(strict_types=1);

namespace StatusLib;

use Laminas\Hydrator\HydratorInterface;
use Laminas\Paginator\Adapter\ArrayAdapter as ArrayPaginator;
use stdClass;

/**
 * Specialized Laminas\Paginator\Adapter\ArrayAdapter instance for returning
 * hydrated entities.
 */
class HydratingArrayPaginator extends ArrayPaginator
{
    /** @var object */
    protected $entityPrototype;

    /** @var HydratorInterface */
    protected $hydrator;

    /**
     * @param array $array
     * @param null|mixed $entityPrototype A prototype entity to use with the hydrator
     */
    public function __construct(array $array = [], ?HydratorInterface $hydrator = null, $entityPrototype = null)
    {
        parent::__construct($array);
        $this->hydrator        = $hydrator;
        $this->entityPrototype = $entityPrototype ?: new stdClass();
    }

    /**
     * Override getItems()
     *
     * Overrides getItems() to return a collection of entities based on the
     * provided Hydrator and entity prototype, if available.
     *
     * @param int $offset
     * @param int $itemCountPerPage
     * @return array
     */
    public function getItems($offset, $itemCountPerPage)
    {
        $set = parent::getItems($offset, $itemCountPerPage);
        if (! $this->hydrator instanceof HydratorInterface) {
            return $set;
        }

        $collection = [];
        foreach ($set as $item) {
            $collection[] = $this->hydrator->hydrate($item, clone $this->entityPrototype);
        }
        return $collection;
    }
}
