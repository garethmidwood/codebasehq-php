<?php

namespace GarethMidwood\CodebaseHQ\TimeSession\Period;

class Month implements Period
{
    public function getPeriod() : string
    {
        return '/month';
    }
}
