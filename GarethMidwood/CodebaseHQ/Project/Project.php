<?php

namespace GarethMidwood\CodebaseHQ\Project;

use GarethMidwood\CodebaseHQ\Ticket;
use GarethMidwood\CodebaseHQ\TimeSession;

class Project 
{
    private $id;
    private $name;
    private $status;
    private $permalink;
    private $totalTicketCount;
    private $openTicketCount;
    private $closedTicketCount;
    /**
     * @var Ticket\Status\Collection
     */
    private $ticketStatusCollection;
    /**
     * @var Ticket\Collection
     */
    private $ticketCollection;
    /**
     * @var TimeSession\Collection
     */
    private $timeSessionCollection;



    /**
     * Constructor
     * @param int $id 
     * @param string $name 
     * @param string $status 
     * @param string $permalink 
     * @param int $totalTicketCount 
     * @param int $openTicketCount 
     * @param int $closedTicketCount 
     * @return void
     */
    public function __construct(
        int $id,
        string $name,
        string $status,
        string $permalink,
        int $totalTicketCount,
        int $openTicketCount,
        int $closedTicketCount
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->status = $status;
        $this->permalink = $permalink;
        $this->totalTicketCount = $totalTicketCount;
        $this->openTicketCount = $openTicketCount;
        $this->closedTicketCount = $closedTicketCount;

        $this->ticketCollection = new Ticket\Collection();
        $this->timeSessionCollection = new TimeSession\Collection();
        $this->ticketStatusCollection = new Ticket\Status\Collection();
    }

    /**
     * Gets project id
     * @return int
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Gets project name
     * @return string
     */
    public function getName() {
        return $this->name;
    }

    /**
     * Gets project status
     * @return string
     */
    public function getStatus() {
        return $this->status;
    }

    /**
     * Gets project permalink
     * @return string
     */
    public function getPermalink() {
        return $this->permalink;
    }

    /**
     * Gets total ticket count
     * @return int
     */
    public function getTotalTicketCount() {
        return $this->totalTicketCount;
    }

    /**
     * Gets open ticket count
     * @return int
     */
    public function getOpenTicketCount() {
        return $this->openTicketCount;
    }

    /**
     * Gets total ticket count
     * @return int
     */
    public function getClosedTicketCount() {
        return $this->closedTicketCount;
    }

    /**
     * Returns ticket collection
     * @return Ticket\Collection
     */
    public function getTickets() {
        return $this->ticketCollection;
    }

    /**
     * Adds a ticket to this project
     * @param Ticket\Ticket $ticket
     * @return Project
     */
    public function addTicket(Ticket\Ticket $ticket) {
        $this->ticketCollection->addTicket($ticket);

        return $this;
    }

    /**
     * Returns time session collection
     * @return TimeSession\Collection
     */
    public function getTimeSessions() {
        return $this->timeSessionCollection;
    }

    /**
     * Adds a time session to this project
     * @param TimeSession\TimeSession $timeSession
     * @return Project
     */
    public function addTimeSession(TimeSession\TimeSession $timeSession) {
        $this->timeSessionCollection->addTimeSession($timeSession);

        return $this;
    }

    /**
     * Returns ticket status collection
     * @return Ticket\Status\Collection
     */
    public function getTicketStatuses() {
        return $this->ticketStatusCollection;
    }

    /**
     * Adds a ticket status to this project
     * @param Ticket\Status\Status $ticketStatus
     * @return Project
     */
    public function addTicketStatus(Ticket\Status\Status $ticketStatus) {
        $this->ticketStatusCollection->addTicketStatus($ticketStatus);

        return $this;
    }
}
