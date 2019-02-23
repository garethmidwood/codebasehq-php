<?php

namespace GarethMidwood\CodebaseHQ\Ticket\Category;

use GarethMidwood\CodebaseHQ\BaseCollection;

class Collection extends BaseCollection
{
    /**
     * Adds a category to the collection
     * @param Category $category 
     * @return void
     */
    public function addTicketCategory(Category $category)
    {
        $this->addItem($category->getId(), $category);
    }
}
