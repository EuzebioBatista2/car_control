<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthTest extends TestCase
{
    /** @test */
    public function only_logged_in_users_can_access(): void
    {
        /* Dashboard */
        $this->get('/dashboard')
            ->assertRedirect('/login');

        /* Customers */
        $this->get('/customers')
            ->assertRedirect('/login');

        $this->get('/customers/search')
            ->assertRedirect('/login');

        /* Vehicles */
        $this->get('/vehicles')
            ->assertRedirect('/login');

        $this->get('/vehicles/search')
            ->assertRedirect('/login');

        /* Reviews */
        $this->get('/reviews')
            ->assertRedirect('/login');

        $this->get('/reviews/search')
            ->assertRedirect('/login');

        /* Files */
        $this->get('/pdf')
            ->assertRedirect('/login');

        $this->get('/excel')
            ->assertRedirect('/login');
    }
}
