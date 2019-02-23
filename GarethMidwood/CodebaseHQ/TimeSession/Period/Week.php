<?php

namespace GarethMidwood\CodebaseHQ\TimeSession\Period;

class Week implements Period
{
    public function getPeriod() : string
    {
        return '/week';
    }
}
