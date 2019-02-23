<?php

namespace GarethMidwood\CodebaseHQ\User;

class User 
{
    private $id;
    private $username;

    /**
     * Constructor
     * @param int $id 
     * @param null|string $username 
     * @return void
     */
    public function __construct(
        int $id,
        string $username = null
    ) {
        $this->id = $id;
        $this->username = $username;
    }

    /**
     * Gets project id
     * @return integer
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Gets project name
     * @return null|string
     */
    public function getUsername() {
        return $this->username;
    }
}
