<?php

namespace GarethMidwood\CodebaseHQ\User;

use GarethMidwood\CodebaseHQ\TimeSession;

class User 
{
    private $id;
    private $username;
    private $company;
    private $emailAddress;
    private $firstName;
    private $lastName;
    private $gravatarUrl;
    private $enabled;
    /**
     * @var TimeSession\Collection
     */
    private $timeSessionCollection;

    /**
     * Constructor
     * @param int $id 
     * @param string $username 
     * @param string $company 
     * @param string $emailAddress 
     * @param string $firstName 
     * @param string $lastName 
     * @param string $gravatarUrl 
     * @param bool $enabled
     * @return void
     */
    public function __construct(
        int $id,
        string $username = null,
        string $company = null,
        string $emailAddress = null,
        string $firstName = null,
        string $lastName = null,
        string $gravatarUrl = null,
        bool $enabled
    ) {
        $this->id = $id;
        $this->username = $username;
        $this->company = $company;
        $this->emailAddress = filter_var($emailAddress, FILTER_VALIDATE_EMAIL);
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->gravatarUrl = $gravatarUrl;
        $this->enabled = $enabled;

        $this->timeSessionCollection = new TimeSession\Collection();
    }

    /**
     * Gets user id
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Gets username
     * @return null|string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Gets company
     * @return null|string
     */
    public function getCompany()
    {
        return $this->company;
    }

    /**
     * Gets email address
     * @return null|string
     */
    public function getEmailAddress()
    {
        return $this->emailAddress;
    }

    /**
     * Gets first name
     * @return null|string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Gets last name
     * @return null|string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Gets gravatar url
     * @return null|string
     */
    public function getGravatarUrl()
    {
        return $this->gravatarUrl;
    }

    /**
     * Gets enabled
     * @return bool
     */
    public function getEnabled()
    {
        return $this->enabled;
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
     * Adds a time session to this user
     * @param TimeSession\TimeSession $timeSession
     * @return Ticket
     */
    public function addTimeSession(TimeSession\TimeSession $timeSession)
    {
        $this->timeSessionCollection->addTimeSession($timeSession);

        return $this;
    }
}
