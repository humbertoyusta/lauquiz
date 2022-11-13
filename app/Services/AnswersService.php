<?php

namespace App\Services;

class AnswersService extends AbstractService
{
    public function __construct()
    {
        parent::__construct('\App\Models\Answer');
    }
}
