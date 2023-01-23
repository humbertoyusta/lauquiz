<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class WelcomePageTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testWelcomePage()
    {
        // Act
        $response = $this->get(route('welcome'));

        // Assert
        $response->assertStatus(200);

        $response->assertSee(['Log In', 'Register', 'Welcome', 'Quizzes']);

        $response->assertDontSee('Log Out');
    }

    public function testWelcomePageAsAdminUser ()
    {
        // Act
        $response = $this->actingAs($this->admin)->get(route('welcome'));

        // Assert
        $response->assertStatus(200);

        $response->assertSee(['Log Out', 'Welcome', 'Quizzes', 'Users']);
    }
}
