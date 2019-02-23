<?php

namespace GarethMidwood\CodebaseHQ\Ticket;

use GarethMidwood\CodebaseHQ\User;

class Ticket 
{   
    private $id;
    private $projectId;
    private $summary;
    private $reporter;
    private $assignee;
    private $category;
    private $priority;
    private $status;
    private $type;
    private $estimatedTime;
    private $updatedAt;
    private $createdAt;
    private $totalTimeSpent;

    /**
     * Constructor
     * @param int $id 
     * @param int $projectId 
     * @param string $summary 
     * @param User\User $reporter 
     * @param User\User $assignee 
     * @param Category\Category $category 
     * @param Priority\Priority $priority 
     * @param Status\Status $status 
     * @param Type\Type $type 
     * @param int|null $estimatedTime 
     * @param \DateTime $updatedAt 
     * @param \DateTime $createdAt 
     * @param int $totalTimeSpent 
     * @return void
     */
    public function __construct(
        int $id,
        int $projectId,
        string $summary,
        User\User $reporter = null,
        User\User $assignee = null,
        Category\Category $category = null,
        Priority\Priority $priority = null,
        Status\Status $status = null,
        Type\Type $type = null,
        int $estimatedTime = null,
        \DateTime $updatedAt,
        \DateTime $createdAt,
        int $totalTimeSpent
    ) {
        $this->id = $id;
        $this->projectId = $projectId;
        $this->summary = $summary;
        $this->reporter = $reporter;
        $this->assignee = $assignee;
        $this->category = $category;
        $this->priority = $priority;
        $this->status = $status;
        $this->type = $type;
        $this->estimatedTime = $estimatedTime;
        $this->updatedAt = $updatedAt;
        $this->createdAt = $createdAt;
        $this->totalTimeSpent = $totalTimeSpent;
    }

    /**
     * Gets Ticket id
     * @return int
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Gets Ticket Project ID
     * @return int
     */
    public function getProjectId() {
        return $this->projectId;
    }

    /**
     * Gets Ticket summary
     * @return string
     */
    public function getSummary() {
        return $this->summary;
    }

    /**
     * Gets Ticket Reporter
     * @return null|User\User
     */
    public function getReporter() {
        return $this->reporter;
    }

    /**
     * Gets Ticket Assignee
     * @return null|User\User
     */
    public function getAssignee() {
        return $this->assignee;
    }

    /**
     * Gets Ticket category
     * @return null|Category\Category
     */
    public function getCategory() {
        return $this->category;
    }

    /**
     * Gets Ticket priority
     * @return null|Priority\Priority
     */
    public function getPriority() {
        return $this->priority;
    }

    /**
     * Gets Ticket status
     * @return null|Status\Status
     */
    public function getStatus() {
        return $this->status;
    }

    /**
     * Gets Ticket type
     * @return null|Type\Type
     */
    public function getType() {
        return $this->type;
    }

    /**
     * Gets Ticket estimated time
     * @return null|int
     */
    public function getEstimate() {
        return $this->estimatedTime;
    }

    /**
     * Gets Ticket total time spent
     * @return int
     */
    public function getTotalTimeSpent() {
        return $this->totalTimeSpent;
    }

    /**
     * Gets Ticket updated date
     * @return \DateTime
     */
    public function getUpdatedAt() {
        return $this->updatedAt;
    }

    /**
     * Gets Ticket created date
     * @return \DateTime
     */
    public function getCreatedAt() {
        return $this->createdAt;
    }
}
