<?php

namespace GarethMidwood\CodebaseHQ;

use GarethMidwood\CodebaseHQ\Project;
use GarethMidwood\CodebaseHQ\Ticket;
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
     * Returns a collection of all tickets in the project
     * @param Project\Project &$project 
     * @param int $pageNo
     * @return bool
     */
    public function tickets(
        Project\Project &$project,
        int $pageNo = 1
    ) : bool
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
                : new Ticket\Category(
                    (int)$ticket['category-id'],
                    $ticket['category']
                );

            $priority = (!isset($ticket['priority']) || is_array($ticket['priority-id']))
                ? null
                : new Ticket\Priority(
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
                : new Ticket\Status(
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
                : new Ticket\Type(
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
}
