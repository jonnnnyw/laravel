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
            'password' => 'Password1'
        ]);

        $this->browse(function (Browser $browser) use ($user) {
            $browser->visit('/login')
                ->type('email', $user->email)
                ->type('password', 'Password1')
                ->press('Login')
                ->assertPathIs('/home');
        });
    }
}
