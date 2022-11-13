<?php

namespace App\Services;

class QuestionsService extends AbstractService
{
    public function __construct()
    {
        parent::__construct('\App\Models\Question');
    }
}
