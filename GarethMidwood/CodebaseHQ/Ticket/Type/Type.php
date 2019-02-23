<?php

namespace GarethMidwood\CodebaseHQ\Ticket\Type;

class Type
{
    private $id;
    private $name;

    /**
     * Constructor
     * @param int $id 
     * @param null|string $name 
     * @return void
     */
    public function __construct(
        int $id,
        string $name = null
    ) {
        $this->id = $id;
        $this->name = $name;
    }

    /**
     * Gets type id
     * @return int
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Gets type name
     * @return null|string
     */
    public function getName() {
        return $this->name;
    }
}
