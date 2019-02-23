<?php

namespace GarethMidwood\CodebaseHQ\Ticket;

class Priority
{
    private $id;
    private $name;
    private $colour;
    private $default;
    private $position;

    /**
     * Constructor
     * @param int $id 
     * @param string $name 
     * @return void
     */
    public function __construct(
        int $id,
        string $name = null,
        string $colour = null,
        bool $default = null,
        int $position = null
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->colour = $colour;
        $this->default = $default;
        $this->position = $position;
    }

    /**
     * Gets priority id
     * @return int
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Gets priority name
     * @return null|string
     */
    public function getName() {
        return $this->name;
    }

    /**
     * Gets priority colour
     * @return null|string
     */
    public function getColour() {
        return $this->colour;
    }

    /**
     * Gets priority default
     * @return null|bool
     */
    public function getDefault() {
        return $this->default;
    }

    /**
     * Gets priority position
     * @return null|int
     */
    public function getPosition() {
        return $this->position;
    }
}
