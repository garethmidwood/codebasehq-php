<?php

namespace GarethMidwood\CodebaseHQ;

abstract class BaseCollection implements \IteratorAggregate
{
    private $items = [];

    /**
     * Adds an item to the collection
     * @param mixed $key 
     * @param mixed $value 
     * @return void
     */
    protected function addItem($key, $value)
    {
        $this->items[$key] = $value;
    }

    /**
     * Returns the number of items in the collection
     * @return int
     */
    public function getCount() : int
    {
        return count($this->items);
    }
    
    /**
     * Returns an item by ID if it exists in the collection
     * @param int $id 
     * @return mixed|null
     */
    public function searchById(int $id)
    {
        return isset($this->items[$id]) ? $this->items[$id] : null;
    }

    /**
     * Returns array iterator
     * @return \ArrayIterator
     */
    public function getIterator() {
        return new \ArrayIterator($this->items);
    }
}
