<?php

namespace GarethMidwood\CodebaseHQ\Project;

class Collection implements \IteratorAggregate
{
    private $projects = [];

    /**
     * Adds a project to the collection
     * @param Project $project 
     * @return void
     */
    public function addProject(Project $project)
    {
        $this->projects[] = $project;
    }

    /**
     * Returns the number of projects in the collection
     * @return int
     */
    public function getCount() : int
    {
        return count($this->projects);
    }

    /**
     * Returns a new collection of active projects
     * @return Collection
     */
    public function getActive() : Collection
    {
        $activeCollection = new Collection();

        foreach($this->projects as $project) {
            if ($project->getStatus() == 'active') {
                $activeCollection->addProject($project);
            }
        }

        return $activeCollection;
    }

    /**
     * Searches for projects by name
     * @param string $searchTerm 
     * @return Collection
     */
    public function searchByName(string $searchTerm, bool $exactMatchOnly = false) : Collection
    {
        $searchResultCollection = new Collection();

        $lowerCaseSearchTerm = strtolower($searchTerm);

        foreach($this->projects as $project) {
            if (
                (!$exactMatchOnly && strpos(strtolower($project->getName()), $lowerCaseSearchTerm) !== false) ||
                ($exactMatchOnly && strtolower($project->getName()) == $lowerCaseSearchTerm)
            ) {
                $searchResultCollection->addProject($project);
            }
        }

        return $searchResultCollection;
    }

    /**
     * Returns array iterator
     * @return \ArrayIterator
     */
    public function getIterator() {
        return new \ArrayIterator($this->projects);
    }
}
