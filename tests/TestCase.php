<?php

namespace Tests;

use App\Models\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public User $user;
    public User $admin;

    protected function setUp(): void
    {
        $this->user = User::factory()->create();
        $this->admin = User::factory()->create(['is_admin' => 'true']);
    }
}
