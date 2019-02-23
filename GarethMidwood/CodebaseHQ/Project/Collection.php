<?php

namespace GarethMidwood\CodebaseHQ\Project;

use GarethMidwood\CodebaseHQ\BaseCollection;

class Collection extends BaseCollection
{
    /**
     * Adds a project to the collection
     * @param Project $project 
     * @return void
     */
    public function addProject(Project $project)
    {
        $this->addItem($project->getId(), $project);
    }

    /**
     * Returns a new collection of active projects
     * @return Collection
     */
    public function getActive() : Collection
    {
        $activeCollection = new Collection();

        foreach($this as $project) {
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

        foreach($this as $project) {
            if (
                (!$exactMatchOnly && strpos(strtolower($project->getName()), $lowerCaseSearchTerm) !== false) ||
                ($exactMatchOnly && strtolower($project->getName()) == $lowerCaseSearchTerm)
            ) {
                $searchResultCollection->addProject($project);
            }
        }

        return $searchResultCollection;
    }
}
