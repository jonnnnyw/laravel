<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;

class AuthTest extends TestCase
{
    /**
     * Test user is redirected to login page
     * if user is not authenticated.
     *
     * @return void
     */
    public function testUserIsRedirectedToLoginPageIfUserIsNotAuthenticated()
    {
        $response = $this->get('/');

        $response->assertRedirect('/login');
    }

    /**
     * Test user is redirected from login to
     * home page if user is  authenticated.
     *
     * @return void
     */
    public function testUserIsRedirectedFromLoginToHomePageIfUserIsAuthenticated()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->get('/login');

        $response->assertRedirect('/home');
    }

    /**
     * Test user is redirected from registration to
     * home page if user is  authenticated.
     *
     * @return void
     */
    public function testUserIsRedirectedFromRegistrationToHomePageIfUserIsAuthenticated()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->get('/register');

        $response->assertRedirect('/home');
    }
}
