<?php

namespace GarethMidwood\CodebaseHQ\Ticket;

use GarethMidwood\CodebaseHQ\BaseCollection;

class Collection extends BaseCollection
{
    const STATUS_CLOSED = true;
    const STATUS_OPEN = false;

    /**
     * Adds a ticket to the collection
     * @param Ticket $ticket 
     * @return void
     */
    public function addTicket(Ticket $ticket)
    {
        $this->addItem($ticket->getId(), $ticket);
    }

    /**
     * Returns a new collection of open tickets
     * @return Collection
     */
    public function getOpen() : Collection
    {
        return $this->getByStatus(self::STATUS_OPEN);
    }

    /**
     * Returns a new collection of closed tickets
     * @return Collection
     */
    public function getClosed() : Collection
    {
        return $this->getByStatus(self::STATUS_CLOSED);
    }

    /**
     * Returns a new collection of tickets that are open/closed 
     * @param bool $returnClosed 
     * @return type
     */
    private function getByStatus(bool $returnClosed) : Collection
    {
        $collection = new Collection();

        foreach($this as $ticket) {
            if ($ticket->getStatus()->isClosed() == $returnClosed) {
                $collection->addticket($ticket);
            }
        }

        return $collection;
    }
}
