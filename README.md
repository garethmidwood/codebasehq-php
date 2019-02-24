# codebasehq-php
A PHP library for the CodebaseHQ API

# Note
This library creates objects for users, projects, tickets etc.
When you make a query to retrieve tickets (this is just an example, it can apply to other classes too) it will attempt to look up the users and link the ticket assignee/reporter with the user.
If you haven't already retrieved users then your ticket will have no assignee or reporter assigned to it. Because of this, the best steps to take are:

- retrieve users
- retrieve projects
- retrieve tickets for the project
- retrieve time sessions for the project

Instructions for each of these steps can be found below.



# Usage
## Connecting to the API
In order to connect to and query the codebase API you need to create a CodebaseHQAccount object

```php
$codebaseHQ = new GarethMidwood\CodebaseHQ\CodebaseHQAccount(
    $apiUser,
    $apiKey,
    $apiHost
);
```



## Retrieving All Users
Users are pulled at the account level

```php
$users = $codebaseHQ->users();
```

This returns a `User\Collection` - searching should be done on the collection, the class has a few helper methods for this



## Retrieving Projects
Projects can be pulled as a whole for the account, or individually by permalink.
Projects are populated with all of their categories, priorities, statuses and types.

### Retrieving All Projects
Projects are also pulled at the account level

```php
$projects = $codebaseHQ->projects();
```

This returns a `Project\Collection` - searching should be done on the collection, the class has a few helper methods for this

### Retrieving Individual Projects
You can pull an individual project by the permalink (note the method name is singular)

```php
$project = $codebaseHQ->project('project-permalink');
```

This returns a `Project\Project` - not a collection



## Retrieving Tickets for a Project
Tickets can only be retrieved if you have a `Project\Project` object. 

```php
$codebaseHQ->tickets($project, $pageNo);

$project->getTickets();
```

The tickets method returns a boolean indicating whether there are further results (as the results are paginated).
The tickets themselves are added to a `Ticket\Collection` in the project. As always, searching should be done on the collection, the class has a few helper methods for this


### Pagination
Tickets are paginated, with 20 per page. You can write a simple loop to pull all tickets for the project

```php
$pageNo = 1;
$moreResultsToRetrieve = true;

while ($moreResultsToRetrieve) {
    $moreResultsToRetrieve = $codebaseHQ->tickets($project, $pageNo);
    $pageNo++;
}
```



## Retrieving Time Sessions for a Project
Time Sessions can only be retrieved if you have a `Project\Project` object.
You must also pass through a period to retrieve the times for, this can be a day/week/month or all - classes exist for each one.

```php
// can be All|Day|Week|Month
$period = new GarethMidwood\CodebaseHQ\TimeSession\Period\Week;

$codebaseHQ->times($project, $period);
```

Time sessions will be associated with the project, the ticket and the user if you have populated those collections.

```php
// times for the project
$project->getTimeSessions();

// times associated to a user
$user->getTimeSessions();

// times associated to a ticket
$ticket->getTimeSessions();
```



