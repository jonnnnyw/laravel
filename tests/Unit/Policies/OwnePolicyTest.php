<?php

namespace Tests\Unit\Policies;

use App\Models\User;
use App\Policies\OwnerPolicy;
use PHPUnit\Framework\TestCase;

class OwnerPolicyTest extends TestCase
{
    /**
     * Test can view any if user has
     * admin role.
     *
     * @return void
     */
    public function testCanViewAnyIfUserHasAdminRole()
    {
        $policy = new OwnerPolicy();

        $user = $this->createMock(User::class);
        $user->method('hasRole')
            ->will($this->returnValueMap([
                [User::ROLE_ADMIN, true]
            ]));

        $this->assertTrue($policy->viewAny($user));
    }

    /**
     * Test cannot view any if user does not
     * have admin role.
     *
     * @return void
     */
    public function testCannotViewAnyIfUserDoesNotHaveAdminRole()
    {
        $policy = new OwnerPolicy();

        $user = $this->createMock(User::class);
        $user->method('hasRole')
            ->will($this->returnValueMap([
               [User::ROLE_ADMIN, false]
            ]));

        $this->assertFalse($policy->viewAny($user));
    }

    /**
     * Test can view if user is owner.
     *
     * @return void
     */
    public function testCanViewIfUserIsOwner()
    {
        $policy = new OwnerPolicy();

        $user = $this->createMock(User::class);

        $model = $this->createMock(User::class);
        $model->method('isOwner')
            ->will($this->returnCallback(function ($owner) use ($user) {
                return $owner === $user;
            }));

        $this->assertTrue($policy->view($user, $model));
    }

    /**
     * Test cannot view if user is not owner.
     *
     * @return void
     */
    public function testCannotViewIfUserNotIsOwner()
    {
        $policy = new OwnerPolicy();

        $user1 = $this->createMock(User::class);
        $user2 = $this->createMock(User::class);

        $model = $this->createMock(User::class);
        $model->method('isOwner')
            ->will($this->returnCallback(function ($owner) use ($user2) {
                return $owner === $user2;
            }));

        $this->assertFalse($policy->view($user1, $model));
    }

    /**
     * Test can view if user is not owner
     * but user has admin role.
     *
     * @return void
     */
    public function testCanViewIfUserIsNotOwnerButUserHasAdminRole()
    {
        $policy = new OwnerPolicy();

        $user1 = $this->createMock(User::class);
        $user1->method('hasRole')
            ->will($this->returnValueMap([
                [User::ROLE_ADMIN, true]
            ]));
        
        $user2 = $this->createMock(User::class);

        $model = $this->createMock(User::class);
        $model->method('isOwner')
            ->will($this->returnCallback(function ($owner) use ($user2) {
                return $owner === $user2;
            }));

        $this->assertTrue($policy->view($user1, $model));
    }

    /**
     * Test can create if user has admin role.
     *
     * @return void
     */
    public function testCanCreateIfUserHasAdminRole()
    {
        $policy = new OwnerPolicy();

        $user = $this->createMock(User::class);
        $user->method('hasRole')
            ->will($this->returnValueMap([
                [User::ROLE_ADMIN, true]
            ]));

        $this->assertTrue($policy->create($user));
    }

    /**
     * Test cannot create if user does not have admin role.
     *
     * @return void
     */
    public function testCannotCreateIfUserDoesNotHaveAdminRole()
    {
        $policy = new OwnerPolicy();

        $user = $this->createMock(User::class);
        $user->method('hasRole')
            ->will($this->returnValueMap([
                [User::ROLE_ADMIN, false]
            ]));

        $this->assertFalse($policy->create($user));
    }

    /**
     * Test can update if user is owner.
     *
     * @return void
     */
    public function testCanUpdateIfUserIsOwner()
    {
        $policy = new OwnerPolicy();

        $user = $this->createMock(User::class);

        $model = $this->createMock(User::class);
        $model->method('isOwner')
            ->will($this->returnCallback(function ($owner) use ($user) {
                return $owner === $user;
            }));

        $this->assertTrue($policy->update($user, $model));
    }

    /**
     * Test cannot update if user is not owner.
     *
     * @return void
     */
    public function testCannotUpdateIfUserIsNotOwner()
    {
        $policy = new OwnerPolicy();

        $user1 = $this->createMock(User::class);
        $user2 = $this->createMock(User::class);

        $model = $this->createMock(User::class);
        $model->method('isOwner')
            ->will($this->returnCallback(function ($owner) use ($user2) {
                return $owner === $user2;
            }));

        $this->assertFalse($policy->update($user1, $model));
    }

    /**
     * Test can update if user is not owner but
     * user has admin role.
     *
     * @return void
     */
    public function testCanUpdateIfUserIsNotOwnerButUserHasAdminRole()
    {
        $policy = new OwnerPolicy();

        $user1 = $this->createMock(User::class);
        $user1->method('hasRole')
            ->will($this->returnValueMap([
                [User::ROLE_ADMIN, true]
            ]));

        $user2 = $this->createMock(User::class);

        $model = $this->createMock(User::class);
        $model->method('isOwner')
            ->will($this->returnCallback(function ($owner) use ($user2) {
                return $owner === $user2;
            }));

        $this->assertTrue($policy->update($user1, $model));
    }

    /**
     * Test can delete if user has admin role.
     *
     * @return void
     */
    public function testCanDeleteIfUserHasAdminRole()
    {
        $policy = new OwnerPolicy();

        $user = $this->createMock(User::class);
        $user->method('hasRole')
            ->will($this->returnValueMap([
                [User::ROLE_ADMIN, true]
            ]));
        
        $model = $this->createMock(User::class);

        $this->assertTrue($policy->delete($user, $model));
    }

    /**
     * Test cannot delete if user does not have admin role.
     *
     * @return void
     */
    public function testCannotDeleteIfUserDoesNotHaveAdminRole()
    {
        $policy = new OwnerPolicy();

        $user = $this->createMock(User::class);
        $user->method('hasRole')
            ->will($this->returnValueMap([
                [User::ROLE_ADMIN, false]
            ]));

        $model = $this->createMock(User::class);

        $this->assertFalse($policy->delete($user, $model));
    }

    /**
     * Test can restore if user has admin role.
     *
     * @return void
     */
    public function testCanRestoreIfUserHasAdminRole()
    {
        $policy = new OwnerPolicy();

        $user = $this->createMock(User::class);
        $user->method('hasRole')
            ->will($this->returnValueMap([
                [User::ROLE_ADMIN, true]
            ]));

        $model = $this->createMock(User::class);

        $this->assertTrue($policy->restore($user, $model));
    }

    /**
     * Test cannot restore if user does not have
     * admin role.
     *
     * @return void
     */
    public function testCannotRestoreIfUserDoesNotHaveAdminRole()
    {
        $policy = new OwnerPolicy();

        $user = $this->createMock(User::class);
        $user->method('hasRole')
            ->will($this->returnValueMap([
                [User::ROLE_ADMIN, false]
            ]));

        $model = $this->createMock(User::class);

        $this->assertFalse($policy->restore($user, $model));
    }

    /**
     * Test can force delete if user has admin role.
     *
     * @return void
     */
    public function testCanForceDeleteIfUserHasAdminRole()
    {
        $policy = new OwnerPolicy();

        $user = $this->createMock(User::class);
        $user->method('hasRole')
            ->will($this->returnValueMap([
                [User::ROLE_ADMIN, true]
            ]));

        $model = $this->createMock(User::class);

        $this->assertTrue($policy->forceDelete($user, $model));
    }

    /**
     * Test cannot force delete if user does not
     * have admin role.
     *
     * @return void
     */
    public function testCannotForceDeleteIfUserDoesNotHaveAdminRole()
    {
        $policy = new OwnerPolicy();

        $user = $this->createMock(User::class);
        $user->method('hasRole')
            ->will($this->returnValueMap([
                [User::ROLE_ADMIN, false]
            ]));

        $model = $this->createMock(User::class);

        $this->assertFalse($policy->forceDelete($user, $model));
    }
}
