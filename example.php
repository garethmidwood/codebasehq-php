<?php

use GarethMidwood\CodebaseHQ\Project;

require_once('vendor/autoload.php');
include_once('config.example.php');

// these params would be defined in the example.config.php file
$codebaseHQ = new GarethMidwood\CodebaseHQ\CodebaseHQAccount(
    $apiUser,
    $apiKey,
    $apiHost
);




$projectName = 'Creode';
$exactMatch = true;






echo '=============' . PHP_EOL;
echo 'LOADING USERS' . PHP_EOL;
echo '=============' . PHP_EOL;

$users = $codebaseHQ->users();

echo 'retrieved ' . $users->getCount() . ' total users' . PHP_EOL;


echo PHP_EOL . PHP_EOL;
echo '================' . PHP_EOL;
echo 'LOADING PROJECTS' . PHP_EOL;
echo '================' . PHP_EOL;

// $projects = $codebaseHQ->projects();

// echo 'retrieved ' . $projects->getCount() . ' total projects' . PHP_EOL;

// $activeProjects = $projects->getActive();

// echo 'retrieved ' . $activeProjects->getCount() . ' active projects' . PHP_EOL;

// $searchedProjects = $activeProjects->searchByName($projectName, $exactMatch);

// echo 'retrieved ' . $searchedProjects->getCount() . ' active searched projects' . PHP_EOL;

$searchedProjects = [$codebaseHQ->project('creode')];



echo PHP_EOL . PHP_EOL;
echo '=====================================' . PHP_EOL;
echo 'LOADING TICKETS FOR SEARCHED PROJECTS' . PHP_EOL;
echo '=====================================' . PHP_EOL;

foreach($searchedProjects as $project) {
    // load tickets
    $pageNo = 1;
    $moreResultsToRetrieve = true;

    echo 'Loading tickets for "' . $project->getName() . '" ';

    while ($moreResultsToRetrieve) {
        echo '.';
        $moreResultsToRetrieve = $codebaseHQ->tickets($project, $pageNo);
        $pageNo++;
    }

    echo ' done' . PHP_EOL;
}









echo PHP_EOL . PHP_EOL;
echo '==================================' . PHP_EOL;
echo 'TICKET STATS FOR SEARCHED PROJECTS' . PHP_EOL;
echo '==================================' . PHP_EOL;

foreach($searchedProjects as $project) {
    $tickets = $project->getTickets();

    echo '=== ' . $project->getName() . PHP_EOL;

    if ($tickets->getCount() == 0) {
        echo '*** no tickets found. Have you populated them? ***' . PHP_EOL;
        continue;
    }

    echo $tickets->getCount() . ' tickets' . PHP_EOL;

    $openTickets = $tickets->getOpen();

    echo $openTickets->getCount() . ' open tickets' . PHP_EOL;

    $closedTickets = $tickets->getClosed();

    echo $closedTickets->getCount() . ' closed tickets' . PHP_EOL;
}


echo PHP_EOL . PHP_EOL;
echo '===================================' . PHP_EOL;
echo 'GETTING TIMES FOR SEARCHED PROJECTS' . PHP_EOL;
echo '===================================' . PHP_EOL;

// can be All|Day|Week|Month
$weekPeriod = new GarethMidwood\CodebaseHQ\TimeSession\Period\Week;

foreach($searchedProjects as $project) {
    $codebaseHQ->times($project, $weekPeriod);
}





echo PHP_EOL . PHP_EOL;
echo '=======================' . PHP_EOL;
echo 'GETTING TIMES FOR USERS' . PHP_EOL;
echo '=======================' . PHP_EOL;


// $users = $users->searchByUsername('gareth', false);
$creodeUsers = $users->searchByCompany('creode', false);
$activeCreodeUsers = $creodeUsers->getActive();


foreach($activeCreodeUsers as $user) {
    echo str_pad($user->getId(), 10) . 'username: ' . str_pad($user->getUsername(), 30) . ' name: ' . str_pad($user->getFirstName() . ' ' . $user->getLastName(),60) . PHP_EOL;

    $times = $user->getTimeSessions();

    foreach($times as $time) {
        echo str_pad('', 10) . $time->getMinutes() . ' minutes on ticket ' . ((null !== $time->getTicket()) ? $time->getTicket()->getId() . ' (estimate ' . $time->getTicket()->getEstimate() . ')' : 'n/a') . ' on project ' . $time->getProject()->getName() . ' doing "' . $time->getSummary() . '"' . PHP_EOL; 
    }
}

