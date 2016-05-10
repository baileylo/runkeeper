<?php

namespace Portico\RunKeeper\Entities;

trait Readable
{
    public function __get($property)
    {
        if (!property_exists($this, $property)) {
            throw new \Exception('Attempted to read undefined property: ' . $property);
        }

        return $this->{$property};
    }
}