<?php

namespace GarethMidwood\CodebaseHQ\Ticket\Priority;

use GarethMidwood\CodebaseHQ\BaseCollection;

class Collection extends BaseCollection
{
    /**
     * Adds a priority to the collection
     * @param Priority $priority 
     * @return void
     */
    public function addTicketPriority(Priority $priority)
    {
        $this->addItem($priority->getId(), $priority);
    }
}
