<?php

namespace GarethMidwood\CodebaseHQ\TimeSession\Period;

class Day implements Period
{
    public function getPeriod() : string
    {
        return '/day';
    }
}
