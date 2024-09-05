<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     */
    public function test_the_application_returns_a_successful_response(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    // login page
    public function test_login_page_is_accessible()
    {
        $response = $this->get('/login');
        $response->assertStatus(200);
    }

    // login page fill admin@admin.com and password
    public function test_login_page_fill_admin_admin_com_and_password()
    {
        $response = $this->post('/login', [
            'email' => 'admin@admin.com',
            'password' => 'password',
        ]);
        $response->assertRedirect('/admin');
    }

    // logout
    public function test_logout()
    {
        $response = $this->get('/logout');
        $response->assertRedirect('/login');
    }


    // re login
    public function test_re_login()
    {
        $response = $this->get('/login');
        $response->assertStatus(200);

        $response = $this->post('/login', [
            'email' => 'admin@admin.com',
            'password' => 'password',
        ]);
        $response->assertRedirect('/admin');

    }



}
