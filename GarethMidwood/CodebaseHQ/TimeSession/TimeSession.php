<?php

namespace GarethMidwood\CodebaseHQ\TimeSession;

use GarethMidwood\CodebaseHQ\Project;
use GarethMidwood\CodebaseHQ\Ticket;
use GarethMidwood\CodebaseHQ\User;

class TimeSession 
{   
    private $id;
    private $project;
    private $summary;
    private $minutes;
    private $sessionDate;
    private $user;
    private $ticket;
    private $updatedAt;
    private $createdAt;

    /**
     * Constructor
     * @param int $id 
     * @param Project\Project $project
     * @param string $summary 
     * @param int $minutes
     * @param \DateTime $sessionDate
     * @param User\User $user
     * @param null|Ticket\Ticket $ticket
     * @param \DateTime $updatedAt 
     * @param \DateTime $createdAt
     * @return void
     */
    public function __construct(
        int $id,
        Project\Project &$project,
        string $summary,
        int $minutes,
        \DateTime $sessionDate,
        User\User &$user = null,
        Ticket\Ticket $ticket = null,
        \DateTime $updatedAt,
        \DateTime $createdAt
    ) {
        $this->id = $id;
        $this->project = $project;
        $this->summary = $summary;
        $this->minutes = $minutes;
        $this->sessionDate = $sessionDate;
        $this->user = $user;
        $this->ticket = $ticket;
        $this->updatedAt = $updatedAt;
        $this->createdAt = $createdAt;
    }

    /**
     * Gets Time Session id
     * @return int
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Gets Time Session Project
     * @return Project\Project
     */
    public function getProject() {
        return $this->project;
    }

    /**
     * Gets Time Session summary
     * @return string
     */
    public function getSummary() {
        return $this->summary;
    }

    /**
     * Gets Time Session minutes
     * @return int
     */
    public function getMinutes() {
        return $this->minutes;
    }

    /**
     * Gets Time Session date
     * @return \DateTime
     */
    public function getSessionDate() {
        return $this->sessionDate;
    }

    /**
     * Gets Time Session User
     * @return null|User\User
     */
    public function getUser() {
        return $this->user;
    }

    /**
     * Gets Time Session Ticket
     * @return null|Ticket\Ticket
     */
    public function getTicket() {
        return $this->ticket;
    }

    /**
     * Gets Time Session updated date
     * @return \DateTime
     */
    public function getUpdatedAt() {
        return $this->updatedAt;
    }

    /**
     * Gets Time Session created date
     * @return \DateTime
     */
    public function getCreatedAt() {
        return $this->createdAt;
    }
}
