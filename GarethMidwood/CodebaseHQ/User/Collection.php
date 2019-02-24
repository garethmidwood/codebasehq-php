<?php

namespace GarethMidwood\CodebaseHQ\User;

use GarethMidwood\CodebaseHQ\BaseCollection;

class Collection extends BaseCollection
{
    /**
     * Adds a user to the collection
     * @param User $user 
     * @return void
     */
    public function addUser(User $user)
    {
        $this->addItem($user->getId(), $user);
    }

    /**
     * Returns a new collection of active users
     * @return Collection
     */
    public function getActive() : Collection
    {
        $activeCollection = new Collection();

        foreach($this as $user) {
            if ($user->getEnabled()) {
                $activeCollection->addUser($user);
            }
        }

        return $activeCollection;
    }

    /**
     * Searches for users by company name
     * @param string $searchTerm 
     * @return Collection
     */
    public function searchByCompany(string $searchTerm, bool $exactMatchOnly = false) : Collection
    {
        $searchResultCollection = new Collection();

        $lowerCaseSearchTerm = strtolower($searchTerm);

        foreach($this as $user) {
            if (
                (!$exactMatchOnly && strpos(strtolower($user->getCompany()), $lowerCaseSearchTerm) !== false) ||
                ($exactMatchOnly && strtolower($user->getCompany()) == $lowerCaseSearchTerm)
            ) {
                $searchResultCollection->addUser($user);
            }
        }

        return $searchResultCollection;
    }

    /**
     * Searches for users by username
     * @param string $searchTerm 
     * @return Collection
     */
    public function searchByUsername(string $searchTerm, bool $exactMatchOnly = false) : Collection
    {
        $searchResultCollection = new Collection();

        $lowerCaseSearchTerm = strtolower($searchTerm);

        foreach($this as $user) {
            if (
                (!$exactMatchOnly && strpos(strtolower($user->getUsername()), $lowerCaseSearchTerm) !== false) ||
                ($exactMatchOnly && strtolower($user->getUsername()) == $lowerCaseSearchTerm)
            ) {
                $searchResultCollection->addUser($user);
            }
        }

        return $searchResultCollection;
    }
}
