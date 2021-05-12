<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\Models\User;

class LoginTest extends DuskTestCase
{
    use DatabaseMigrations;

    /**
     * Test can log in
     *
     * @return void
     */
    public function testCanLoginIn()
    {
        $user = User::factory()->create([
            'name' => 'Joe Blogs',
            'email' => 'joe@blogs.com',
        ]);

        $user->password = 'Password1';
        $user->save();
    
        $this->browse(function (Browser $browser) use ($user) {
            $browser->visit('/login')
                ->type('email', $user->email)
                ->type('password', 'Password1')
                ->press('Login')
                ->assertPathIs('/')
                ->logout();
        });
    }

    /**
     * Test error message is displayed if email
     * is blank.
     *
     * @return void
     */
    public function testErrorMessageIsDisplayedIfEmailIsBlank()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                ->type('password', 'Password1')
                ->press('Login')
                ->assertSee('The email field is required.');
        });
    }

    /**
     * Test error message is displayed if password
     * is blank.
     *
     * @return void
     */
    public function testErrorMessageIsDisplayedIfPasswordIsBlank()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                ->type('email', 'joe@blogs.com')
                ->press('Login')
                ->assertSee('The password field is required.');
        });
    }

    /**
     * Test error message is displayed if credentials
     * are incorrect
     *
     * @return void
     */
    public function testErrorMessageIsDisplayedIfCredentialsAreIncorrect()
    {
        $user = User::factory()->create([
            'name' => 'Joe Blogs',
            'email' => 'joe@blogs.com',
        ]);

        $user->password = 'Password1';
        $user->save();

        $this->browse(function (Browser $browser) use ($user) {
            $browser->visit('/login')
                ->type('email', $user->email)
                ->type('password', 'InvalidPassword')
                ->press('Login')
                ->assertSee('Invalid login.');
        });
    }
}
