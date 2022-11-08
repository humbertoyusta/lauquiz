<?php

namespace App\Services;

class QuizService extends AbstractService {
    public function __construct()
    {
        parent::__construct('\App\Models\Answer');
    }
};