<?php

namespace GarethMidwood\CodebaseHQ\Ticket\Type;

use GarethMidwood\CodebaseHQ\BaseCollection;

class Collection extends BaseCollection
{
    /**
     * Adds a ticket type to the collection
     * @param Type $status 
     * @return void
     */
    public function addTicketType(Type $type)
    {
        $this->addItem($type->getId(), $type);
    }
}
