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
     * @var Ticket\Category\Collection
     */
    private $ticketCategoryCollection;
    /**
     * @var Ticket\Priority\Collection
     */
    private $ticketPriorityCollection;
    /**
     * @var Ticket\Status\Collection
     */
    private $ticketStatusCollection;
    /**
     * @var Ticket\Type\Collection
     */
    private $ticketTypeCollection;
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
        $this->ticketCategoryCollection = new Ticket\Category\Collection();
        $this->ticketPriorityCollection = new Ticket\Priority\Collection();
        $this->ticketStatusCollection = new Ticket\Status\Collection();
        $this->ticketTypeCollection = new Ticket\Type\Collection();
    }

    /**
     * Gets project id
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Gets project name
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Gets project status
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Gets project permalink
     * @return string
     */
    public function getPermalink()
    {
        return $this->permalink;
    }

    /**
     * Gets total ticket count
     * @return int
     */
    public function getTotalTicketCount()
    {
        return $this->totalTicketCount;
    }

    /**
     * Gets open ticket count
     * @return int
     */
    public function getOpenTicketCount()
    {
        return $this->openTicketCount;
    }

    /**
     * Gets total ticket count
     * @return int
     */
    public function getClosedTicketCount()
    {
        return $this->closedTicketCount;
    }

    /**
     * Returns ticket collection
     * @return Ticket\Collection
     */
    public function getTickets()
    {
        return $this->ticketCollection;
    }

    /**
     * Adds a ticket to this project
     * @param Ticket\Ticket $ticket
     * @return Project
     */
    public function addTicket(Ticket\Ticket $ticket)
    {
        $this->ticketCollection->addTicket($ticket);

        return $this;
    }

    /**
     * Returns time session collection
     * @return TimeSession\Collection
     */
    public function getTimeSessions()
    {
        return $this->timeSessionCollection;
    }

    /**
     * Adds a time session to this project
     * @param TimeSession\TimeSession $timeSession
     * @return Project
     */
    public function addTimeSession(TimeSession\TimeSession $timeSession)
    {
        $this->timeSessionCollection->addTimeSession($timeSession);

        return $this;
    }

    /**
     * Returns ticket category collection
     * @return Ticket\Category\Collection
     */
    public function getTicketCategories()
    {
        return $this->ticketCategoryCollection;
    }

    /**
     * Returns ticket category by id
     * @param int $id 
     * @return null|Ticket\Category\Category
     */
    public function getTicketCategoryById(int $id)
    {
        return $this->ticketCategoryCollection->searchById($id);
    }

    /**
     * Adds a ticket category to this project
     * @param Ticket\Category\Category $ticketCategory
     * @return Project
     */
    public function addTicketCategory(Ticket\Category\Category $ticketCategory)
    {
        $this->ticketCategoryCollection->addTicketCategory($ticketCategory);

        return $this;
    }

    /**
     * Returns ticket priority collection
     * @return Ticket\Priority\Collection
     */
    public function getTicketPriorities()
    {
        return $this->ticketPriorityCollection;
    }

    /**
     * Returns ticket priority by id
     * @param int $id 
     * @return null|Ticket\Priority\Priority
     */
    public function getTicketPriorityById(int $id)
    {
        return $this->ticketPriorityCollection->searchById($id);
    }

    /**
     * Adds a ticket priority to this project
     * @param Ticket\Priority\Priority $ticketStatus
     * @return Project
     */
    public function addTicketPriority(Ticket\Priority\Priority $ticketPriority)
    {
        $this->ticketPriorityCollection->addTicketPriority($ticketPriority);

        return $this;
    }

    /**
     * Returns ticket status collection
     * @return Ticket\Status\Collection
     */
    public function getTicketStatuses()
    {
        return $this->ticketStatusCollection;
    }

    /**
     * Returns ticket status by id
     * @param int $id 
     * @return null|Ticket\Status\Status
     */
    public function getTicketStatusById(int $id)
    {
        return $this->ticketStatusCollection->searchById($id);
    }

    /**
     * Adds a ticket status to this project
     * @param Ticket\Status\Status $ticketStatus
     * @return Project
     */
    public function addTicketStatus(Ticket\Status\Status $ticketStatus)
    {
        $this->ticketStatusCollection->addTicketStatus($ticketStatus);

        return $this;
    }

    /**
     * Returns ticket type collection
     * @return Ticket\Type\Collection
     */
    public function getTicketTypes()
    {
        return $this->ticketTypeCollection;
    }

    /**
     * Returns ticket type by id
     * @param int $id 
     * @return null|Ticket\Type\Type
     */
    public function getTicketTypeById(int $id)
    {
        return $this->ticketTypeCollection->searchById($id);
    }

    /**
     * Adds a ticket type to this project
     * @param Ticket\Type\Type $ticketStatus
     * @return Project
     */
    public function addTicketType(Ticket\Type\Type $ticketType)
    {
        $this->ticketTypeCollection->addTicketType($ticketType);

        return $this;
    }
}
