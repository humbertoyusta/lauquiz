<?php

namespace App\Services;

use App\Models\User;

class UsersService extends AbstractService
{
    public function __construct()
    {
        parent::__construct(
            User::class,
            [],
        );
    }
}
