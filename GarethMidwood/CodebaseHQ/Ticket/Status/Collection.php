<?php

namespace GarethMidwood\CodebaseHQ\Ticket\Status;

use GarethMidwood\CodebaseHQ\BaseCollection;

class Collection extends BaseCollection
{
    /**
     * Adds a ticket status to the collection
     * @param Status $status 
     * @return void
     */
    public function addTicketStatus(Status $status)
    {
        $this->addItem($status->getId(), $status);
    }
}
