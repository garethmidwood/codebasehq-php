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
     * @var User\Collection
     */
    private $userCollection;

    /**
     * Constructor
     * @param string $apiUser 
     * @param string $apiKey 
     * @param string $apiHostname
     * @return void
     */
    public function __construct(
        $apiUser,
        $apiKey,
        $apiHostname
    ) {
        parent::__construct(
            $apiUser,
            $apiKey,
            $apiHostname
        );

        $this->projectCollection = new Project\Collection();
        $this->userCollection = new User\Collection();
    }

    /**
     * Returns a collection of all projects
     * @return Project\Collection
     */
    public function projects() : Project\Collection
    {
        $projects = $this->get('/projects');

        foreach($projects['project'] as $projectData) {
            $project = new Project\Project(
                (int)$projectData['project-id'],
                $projectData['name'],
                $projectData['status'],
                $projectData['permalink'],
                (int)$projectData['total-tickets'],
                (int)$projectData['open-tickets'],
                (int)$projectData['closed-tickets']
            );

            $this->categories($project);
            $this->priorities($project);
            $this->statuses($project);
            $this->types($project);

            $this->projectCollection->addProject($project);
        }

        return $this->projectCollection;
    }

    /**
     * Returns a collection of all projects
     * @param string $permalink
     * @return Project\Project
     */
    public function project(string $permalink) : Project\Project
    {
        $projectData = $this->get('/' . $permalink);

        $project = new Project\Project(
            (int)$projectData['project-id'],
            $projectData['name'],
            $projectData['status'],
            $projectData['permalink'],
            (int)$projectData['total-tickets'],
            (int)$projectData['open-tickets'],
            (int)$projectData['closed-tickets']
        );

        $this->categories($project);
        $this->priorities($project);
        $this->statuses($project);
        $this->types($project);

        return $project;
    }


    /**
     * Returns a collection of all users
     * @return User\Collection
     */
    public function users() : User\Collection
    {
        $users = $this->get('/users');

        foreach($users['user'] as $user) {

            $this->userCollection->addUser(
                new User\User(
                    (int)$user['id'],
                    (isset($user['username']) && is_string($user['username'])) ? $user['username'] : null,
                    (isset($user['company']) && is_string($user['company'])) ? $user['company'] : null,
                    (isset($user['email-address']) && is_string($user['email-address'])) ? $user['email-address'] : null,
                    (isset($user['first-name']) && is_string($user['first-name'])) ? $user['first-name'] : null,
                    (isset($user['last-name']) && is_string($user['last-name'])) ? $user['last-name'] : null,
                    (isset($user['gravatar-url']) && is_string($user['gravatar-url'])) ? $user['gravatar-url'] : null,
                    filter_var($user['enabled'], FILTER_VALIDATE_BOOLEAN)
                )
            );
        }

        return $this->userCollection;
    }

    /**
     * Populates categories for a project
     * @param Project\Project &$project 
     * @return bool
     */
    private function categories(Project\Project &$project) : bool
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
    private function priorities(Project\Project &$project) : bool
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
    private function statuses(Project\Project &$project) : bool
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
    private function types(Project\Project &$project) : bool
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

            $assignee = isset($ticket['assignee-id']) ? $this->userCollection->searchById((int)$ticket['assignee-id']) : null;

            $reporter = isset($ticket['reporter-id']) ? $this->userCollection->searchById((int)$ticket['reporter-id']) : null;

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

        $timeSessions = $this->get($url);

        if (!isset($timeSessions['time-session'])) {
            return false;
        }

        foreach($timeSessions['time-session'] as $timeSession) {
            if (!is_array($timeSession) || !isset($timeSession['id'])) {
                continue;
            }

            $user = isset($timeSession['user-id']) ? $this->userCollection->searchById((int)$timeSession['user-id']) : null;

            $ticket = (!isset($timeSession['ticket-id']) || is_array($timeSession['ticket-id']))
                ? null 
                : $project->getTickets()->searchById((int)$timeSession['ticket-id']);

            $timeSession = new TimeSession\TimeSession(
                (int)$timeSession['id'],
                $project,
                $timeSession['summary'],
                (int)$timeSession['minutes'],
                new \DateTime($timeSession['session-date']),
                $user,
                $ticket,
                new \DateTime($timeSession['updated-at']),
                new \DateTime($timeSession['created-at'])
            );

            $project->addTimeSession($timeSession);

            if (isset($ticket)) {
                $ticket->addTimeSession($timeSession);    
            }

            if (isset($user)) {
                $user->addTimeSession($timeSession);
            }
        }

        return true;
    }
}
