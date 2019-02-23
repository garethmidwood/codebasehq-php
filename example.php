<?php

require_once('vendor/autoload.php');
include_once('config.example.php');

// these params would be defined in the example.config.php file
$ticketingSystem = new GarethMidwood\CodebaseHQ\CodebaseHQAccount(
    $apiUser,
    $apiKey,
    $apiHost
);

$projects = $ticketingSystem->projects();

echo 'retrieved ' . $projects->getCount() . ' total projects' . PHP_EOL;

// foreach($projects as $project) {
//     echo $project->getName() . ' : ' . $project->getStatus() . PHP_EOL;
// }

$activeProjects = $projects->getActive();

echo 'retrieved ' . $activeProjects->getCount() . ' active projects' . PHP_EOL;

echo '---' . PHP_EOL;

$searchedProjects = $activeProjects->searchByName('Creode');

// populate the tickets for each project
foreach($searchedProjects as $project) {
    $pageNo = 1;
    $moreResultsToRetrieve = true;

    while ($moreResultsToRetrieve) {
        $moreResultsToRetrieve = $ticketingSystem->tickets($project, $pageNo);
        $pageNo++;
    }
}


foreach($searchedProjects as $project) {
    $tickets = $project->getTickets();

    echo $tickets->getCount() . ' tickets in ' . $project->getName() . PHP_EOL;

    $openTickets = $tickets->getOpen();

    echo $openTickets->getCount() . ' open tickets in ' . $project->getName() . PHP_EOL;

    $closedTickets = $tickets->getClosed();

    echo $closedTickets->getCount() . ' closed tickets in ' . $project->getName() . PHP_EOL;

    echo '---' . PHP_EOL;
}
