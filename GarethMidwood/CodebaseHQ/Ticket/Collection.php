<?php

namespace GarethMidwood\CodebaseHQ\Ticket;

class Collection implements \IteratorAggregate
{
    private $tickets = [];

    /**
     * Adds a ticket to the collection
     * @param Ticket $ticket 
     * @return void
     */
    public function addTicket(Ticket $ticket)
    {
        $this->tickets[] = $ticket;
    }

    /**
     * Returns the number of tickets in the collection
     * @return int
     */
    public function getCount() : int
    {
        return count($this->tickets);
    }

    /**
     * Returns a new collection of open tickets
     * @return Collection
     */
    public function getOpen() : Collection
    {
        $openCollection = new Collection();

        foreach($this->tickets as $ticket) {
            if (!$ticket->getStatus()->isClosed()) {
                $openCollection->addticket($ticket);
            }
        }

        return $openCollection;
    }

    /**
     * Returns a new collection of closed tickets
     * @return Collection
     */
    public function getClosed() : Collection
    {
        $closedCollection = new Collection();

        foreach($this->tickets as $ticket) {
            if ($ticket->getStatus()->isClosed()) {
                $closedCollection->addticket($ticket);
            }
        }

        return $closedCollection;
    }

    /**
     * Returns array iterator
     * @return \ArrayIterator
     */
    public function getIterator() {
        return new \ArrayIterator($this->tickets);
    }
}
