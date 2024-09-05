<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class LoginTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     */
    public function testExample(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                ->assertSee('projects');
        });


    }

    // go to login page
    public function test_go_to_login_page()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                ->assertSee('Log In')
                ->clickLink('Log In')
                ->assertPathIs('/login');
        });
    }

    // login with valid credentials
    public function test_login_with_valid_credentials()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                ->assertSee('Password')
                ->type('email', 'admin@admin.com')
                ->type('password', 'password')
                ->press('Sign in')
                ->assertPathIs('/admin');
        });
    }

    // assert Manage Projects
    public function test_logout()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/admin')
                ->waitForText('Projects')
                ->clickLink('Manage Projects')
                ->assertPathIs('/admin/projects');
        });
    }

    // assert New Project error
    public function test_new_project_fail()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/admin/projects')
                ->waitForText('Projects')
                ->click('[data-bs-target="#newProjectModal"]')
                ->waitForText('Create New Project')
                ->type('description', 'Test Project')
                ->click('.modal-footer #submitNewProject')
                ->waitForText('The name');
        });
    }

    // assert New Project
    public function test_new_project_success()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/admin/projects')
                ->waitForText('Projects')
                ->click('[data-bs-target="#newProjectModal"]')
                ->waitForText('Create New Project')
                ->type('description', 'Test Project')
                ->type('name', 'Test Project')
                ->click('.modal-footer #submitNewProject')
                ->waitForText('created successfully');
        });
    }

    // wait for Test Project and click Test Project
    public function test_wait_for_test_project_and_click_test_project()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/admin/projects')
                ->waitForText('Test Project')
                ->click('tbody tr a')
                ->waitForText('Not Completed Tasks');
        });
    }

    // [data-bs-target="#newTaskModal"] name=Task1
    public function test_new_task_success()
    {
        $this->browse(function (Browser $browser) {
            $browser
                ->waitForText('Not Completed Tasks')
                ->click('[data-bs-target="#newTaskModal"]')
                ->waitForText('Create New Task')
                ->type('name', 'Task1')
                ->click('.modal-footer #submitNewTask')
                ->waitForText('created successfully')
                ->screenshot('new_task_success');
        });
    }


    // delete project
    public function test_delete_project()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/admin/projects')
                ->waitForText('Projects')
                ->click('.delete-project')
                ->acceptDialog()
                ->waitForText('deleted successfully');
        });
    }

    // go to logout page and after go to admin/projects assertRedirect /login
    public function test_logout_and_assert_redirect_to_login()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/logout')
                ->assertPathIs('/login');
        });
    }

}
