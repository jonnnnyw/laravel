<?php

namespace Tests\Unit;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    /**
     * Test password is encrypted when setting password.
     *
     * @return void
     */
    public function testPasswordIsEncryptedWhenSettingPassword()
    {
        $plaintext = 'aTestPassword1';
        $encrypted = password_hash($plaintext, PASSWORD_BCRYPT);

        Hash::shouldReceive('make')
            ->once()
            ->with($plaintext)
            ->andReturn($encrypted);

        $user = new User([
            'name' => 'Joe Blogs',
            'email' => 'joe@blogs.com',
            'password' => $plaintext,
        ]);

        $this->assertEquals($encrypted, $user->password);
    }
}
