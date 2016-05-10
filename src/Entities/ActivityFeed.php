<?php

namespace Portico\RunKeeper\Entities;

use IteratorAggregate;
use Traversable;

class ActivityFeed implements IteratorAggregate
{
    use Readable;

    /** @var string */
    private $prev;

    /** @var string */
    private $next;

    /** @var int */
    private $size;

    /** @var Activity[] */
    private $items;

    /**
     * Retrieve an external iterator
     *
     * @return \ArrayIterator
     */
    public function getIterator()
    {
        return new \ArrayIterator($this->items);
    }
}
