<?php

namespace GarethMidwood\CodebaseHQ\Ticket;

class Status
{
    private $id;
    private $name;
    private $colour;
    private $treatAsClosed;
    private $order;

    /**
     * Constructor
     * @param int $id 
     * @param string $name 
     * @param string $colour
     * @param bool $treatAsClosed
     * @param int $order
     * @return void
     */
    public function __construct(
        int $id,
        string $name = null,
        string $colour = null,
        bool $treatAsClosed = null,
        int $order = null
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->colour = $colour;
        $this->treatAsClosed = $treatAsClosed;
        $this->order = $order;
    }

    /**
     * Gets status id
     * @return int
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Gets status name
     * @return null|string
     */
    public function getName() {
        return $this->name;
    }

    /**
     * Gets status colour
     * @return null|string
     */
    public function getColour() {
        return $this->colour;
    }

    /**
     * Returns whether the status is closed or not
     * @return null|bool
     */
    public function isClosed() {
        return $this->treatAsClosed;
    }

    /**
     * Gets status order
     * @return null|int
     */
    public function getOrder() {
        return $this->order;
    }
}
