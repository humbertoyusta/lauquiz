<?php

namespace App\Services;

class QuizzesService extends AbstractService {
    public function __construct()
    {
        parent::__construct('\App\Models\Quiz');
    }
};