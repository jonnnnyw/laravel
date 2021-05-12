<?php

namespace Tests\Unit\Models;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    /**
     * Test user password is encrypted when setting password.
     *
     * @return void
     */
    public function testUserPasswordIsEncryptedWhenSettingPassword()
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

    /**
     * Test user has role.
     *
     * @return void
     */
    public function testUserHasRole()
    {
        $user = new User();
        $user->roles = [User::ROLE_ADMIN];

        $this->assertTrue($user->hasRole(User::ROLE_ADMIN));
    }

    /**
     * Testu user does not have role.
     *
     * @return void
     */
    public function testUserDoesNotHaveRole()
    {
        $user = new User();
        $user->roles = [User::ROLE_ADMIN];

        $this->assertFalse($user->hasRole(User::ROLE_USER));
    }

    /**
     * Test user has default role if roles
     * are not set.
     *
     * @return void
     */
    public function testUserHasDefaultRoleIfRolesAreNotSet()
    {
        $this->assertTrue((new User())->hasRole(User::ROLE_USER));
    }

    /**
     * Test user is owner.
     *
     * @return void
     */
    public function testUserIsOwner()
    {
        $user = new User();
        $user->id = 5;

        $owner = $this->createMock(User::class);
        $owner->method('__get')
            ->with('id')
            ->will($this->returnValue(5));

        $this->assertTrue($user->isOwner($owner));
    }

    /**
     * Test user is not owner.
     *
     * @return void
     */
    public function testUserIsNotOwner()
    {
        $user = new User();
        $user->id = 9;

        $owner = $this->createMock(User::class);
        $owner->method('__get')
            ->with('id')
            ->will($this->returnValue(5));

        $this->assertFalse($user->isOwner($owner));
    }
}
