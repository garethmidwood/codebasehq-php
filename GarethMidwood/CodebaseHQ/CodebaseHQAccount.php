<?php

namespace GarethMidwood\CodebaseHQ;

use GarethMidwood\CodebaseHQ\Project;
use GarethMidwood\CodebaseHQ\Ticket;
use GarethMidwood\CodebaseHQ\TimeSession\Period;
use GarethMidwood\CodebaseHQ\User;

class CodebaseHQAccount extends CodebaseHQConnector
{
    /**
     * @var Project\Collection
     */
    private $projectCollection;

    /**
     * Returns a collection of all projects
     * @return Project\Collection
     */
    public function projects() : Project\Collection
    {
        $projects = $this->get('/projects');

        $this->projectCollection = new Project\Collection();

        foreach($projects['project'] as $project) {
            $this->projectCollection->addProject(
                new Project\Project(
                    (int)$project['project-id'],
                    $project['name'],
                    $project['status'],
                    $project['permalink'],
                    (int)$project['total-tickets'],
                    (int)$project['open-tickets'],
                    (int)$project['closed-tickets']
                )
            );
        }

        return $this->projectCollection;
    }

    /**
     * Populates categories for a project
     * @param Project\Project &$project 
     * @return bool
     */
    public function categories(Project\Project &$project) : bool
    {
        $url = '/' . $project->getPermalink() . '/tickets/categories';

        $categories = $this->get($url);

        if (!isset($categories['ticketing-category'])) {
            return false;
        }

        foreach($categories['ticketing-category'] as $category) {
            if (!is_array($category) || !isset($category['id'])) {
                continue;
            }

            $project->addTicketCategory(
                new Ticket\Category\Category(
                    (int)$category['id'],
                    $category['name']
                )
            );
        }

        return true;
    }

    /**
     * Populates priorities for a project
     * @param Project\Project &$project 
     * @return bool
     */
    public function priorities(Project\Project &$project) : bool
    {
        $url = '/' . $project->getPermalink() . '/tickets/priorities';

        $priorities = $this->get($url);

        if (!isset($priorities['ticketing-priority'])) {
            return false;
        }

        foreach($priorities['ticketing-priority'] as $priority) {
            if (!is_array($priority) || !isset($priority['id'])) {
                continue;
            }

            $project->addTicketPriority(
                new Ticket\Priority\Priority(
                    (int)$priority['id'],
                    (isset($priority['name']) && is_string($priority['name']))
                        ? $priority['name']
                        : null,
                    (isset($priority['colour']) && is_string($priority['colour']))
                        ? $priority['colour']
                        : null,
                    (isset($priority['default']) && is_string($priority['default']))
                        ? (bool)$priority['default']
                        : null,
                    (isset($priority['position']) && is_string($priority['position']))
                        ? (int)$priority['position']
                        : null
                )
            );
        }

        return true;
    }

    /**
     * Populates statuses for a project
     * @param Project\Project &$project 
     * @return bool
     */
    public function statuses(Project\Project &$project) : bool
    {
        $url = '/' . $project->getPermalink() . '/tickets/statuses';

        $statuses = $this->get($url);

        if (!isset($statuses['ticketing-status'])) {
            return false;
        }

        foreach($statuses['ticketing-status'] as $status) {
            if (!is_array($status) || !isset($status['id'])) {
                continue;
            }

            $project->addTicketStatus(
                new Ticket\Status\Status(
                    (int)$status['id'],
                    (isset($status['name']) && is_string($status['name']))
                        ? $status['name']
                        : null,
                    (isset($status['colour']) && is_string($status['colour']))
                        ? $status['colour']
                        : null,
                    (isset($status['treat-as-closed']) && is_string($status['treat-as-closed']))
                        ? filter_var($status['treat-as-closed'], FILTER_VALIDATE_BOOLEAN)
                        : null,
                    (isset($status['order']) && is_string($status['order']))
                        ? (int)$status['order']
                        : null
                )
            );
        }

        return true;
    }

    /**
     * Populates types for a project
     * @param Project\Project &$project 
     * @return bool
     */
    public function types(Project\Project &$project) : bool
    {
        $url = '/' . $project->getPermalink() . '/tickets/types';

        $types = $this->get($url);

        if (!isset($types['ticketing-type'])) {
            return false;
        }

        foreach($types['ticketing-type'] as $type) {
            if (!is_array($type) || !isset($type['id'])) {
                continue;
            }

            $project->addTicketType(
                new Ticket\Type\Type(
                    (int)$type['id'],
                    (isset($type['name']) && is_string($type['name']))
                        ? $type['name']
                        : null
                )
            );
        }

        return true;
    }

    /**
     * Populates tickets on the given project
     * @param Project\Project &$project 
     * @param int $pageNo
     * @return bool
     */
    public function tickets(Project\Project &$project, int $pageNo = 1) : bool
    {
        $url = '/' . $project->getPermalink() . '/tickets?page=' . $pageNo;

        $tickets = $this->get($url);

        if (!isset($tickets['ticket'])) {
            return false;
        }

        foreach($tickets['ticket'] as $ticket) {
            if (!is_array($ticket) || !isset($ticket['ticket-id'])) {
                continue;
            }

            $assignee = (!isset($ticket['assignee']) || is_array($ticket['assignee']))
                ? null 
                : new User\User(
                    (int)$ticket['assignee-id'],
                    $ticket['assignee']
                );

            $reporter = (!isset($ticket['reporter']) || is_array($ticket['reporter']))
                ? null 
                : new User\User(
                    (int)$ticket['reporter-id'],
                    $ticket['reporter']
                );

            $category = $project->getTicketCategoryById((int)$ticket['category-id']);

            $priority = $project->getTicketPriorityById((int)$ticket['priority-id']);

            $status = $project->getTicketStatusById((int)$ticket['status-id']);

            $type = $project->getTicketTypeById((int)$ticket['type-id']);

            $estimatedTime = (isset($ticket['estimated-time']) && is_string($ticket['estimated-time']))
                ? $ticket['estimated-time']
                : null;

            $project->addTicket(
                new Ticket\Ticket(
                    (int)$ticket['ticket-id'],
                    (int)$ticket['project-id'],
                    $ticket['summary'],
                    $reporter,
                    $assignee,
                    $category,
                    $priority,
                    $status,
                    $type,
                    $estimatedTime,
                    new \DateTime($ticket['updated-at']),
                    new \DateTime($ticket['created-at']),
                    (int)$ticket['total-time-spent']
                )
            );
        }

        return true;
    }

    /**
     * Populates time sessions on the given project
     * @param Project\Project &$project 
     * @param Period\Period $period 
     * @return bool
     */
    public function times(Project\Project &$project, Period\Period $period) : bool
    {
        $url = '/' . $project->getPermalink() . '/time_sessions' . $period->getPeriod();

        echo $url . PHP_EOL;

        $timeSessions = $this->get($url);

        if (!isset($timeSessions['time-session'])) {
            return false;
        }

        echo 'contains ' . count($timeSessions['time-session']) . ' items' . PHP_EOL;

        foreach($timeSessions['time-session'] as $timeSession) {
            if (!is_array($timeSession) || !isset($timeSession['id'])) {
                continue;
            }

            $user = (!isset($timeSession['user-id']) || is_array($timeSession['user-id']))
                ? null 
                : new User\User(
                    (int)$timeSession['user-id'],
                    null
                );

            $ticketId = (!isset($timeSession['ticket-id']) || is_array($timeSession['ticket-id']))
                ? null 
                : $timeSession['ticket-id'];

            $project->addTimeSession(
                new TimeSession\TimeSession(
                    (int)$timeSession['id'],
                    $timeSession['summary'],
                    (int)$timeSession['minutes'],
                    new \DateTime($timeSession['session-date']),
                    $user,
                    $ticketId,
                    new \DateTime($timeSession['updated-at']),
                    new \DateTime($timeSession['created-at'])
                )
            );
        }

        return true;
    }
}
