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

            $category = (!isset($ticket['category']) || is_array($ticket['category']))
                ? null
                : new Ticket\Category\Category(
                    (int)$ticket['category-id'],
                    $ticket['category']
                );

            $priority = (!isset($ticket['priority']) || is_array($ticket['priority-id']))
                ? null
                : new Ticket\Priority\Priority(
                    (int)$ticket['priority-id'],
                    (isset($ticket['priority']['name']) && is_string($ticket['priority']['name']))
                        ? $ticket['priority']['name']
                        : null,
                    (isset($ticket['priority']['colour']) && is_string($ticket['priority']['colour']))
                        ? $ticket['priority']['colour']
                        : null,
                    (isset($ticket['priority']['default']) && is_string($ticket['priority']['default']))
                        ? (bool)$ticket['priority']['default']
                        : null,
                    (isset($ticket['priority']['position']) && is_string($ticket['priority']['position']))
                        ? (int)$ticket['priority']['position']
                        : null
                );

            $status = (!isset($ticket['status']) || is_array($ticket['status-id']))
                ? null
                : new Ticket\Status\Status(
                    (int)$ticket['status-id'],
                    (isset($ticket['status']['name']) && is_string($ticket['status']['name']))
                        ? $ticket['status']['name']
                        : null,
                    (isset($ticket['status']['colour']) && is_string($ticket['status']['colour']))
                        ? $ticket['status']['colour']
                        : null,
                    (isset($ticket['status']['treat-as-closed']) && is_string($ticket['status']['treat-as-closed']))
                        ? filter_var($ticket['status']['treat-as-closed'], FILTER_VALIDATE_BOOLEAN)
                        : null,
                    (isset($ticket['status']['order']) && is_string($ticket['status']['order']))
                        ? (int)$ticket['status']['order']
                        : null
                );

            $type = (!isset($ticket['type-id']) || is_array($ticket['type-id']))
                ? null
                : new Ticket\Type\Type(
                    (int)$ticket['type-id'],
                    (isset($ticket['type']['name']) && is_string($ticket['type']['name']))
                        ? $ticket['type']['name']
                        : null
                );

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
