<?php

namespace App\Services;

class QuestionService extends AbstractService {
    public function __construct()
    {
        parent::__construct('\App\Models\Question');
    }
};