<?php

namespace GarethMidwood\CodebaseHQ\Ticket\Category;

class Category
{
    private $id;
    private $name;

    /**
     * Constructor
     * @param int $id 
     * @param string $name 
     * @return void
     */
    public function __construct(
        int $id,
        string $name
    ) {
        $this->id = $id;
        $this->name = $name;
    }

    /**
     * Gets category id
     * @return int
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Gets category name
     * @return string
     */
    public function getName() {
        return $this->name;
    }
}
