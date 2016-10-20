<?php
namespace Golem\Auth\Test;

use Golem\Auth\Test\Example\Repository;
use Golem\Auth\Storage\MemoryStorage;
use Golem\Auth\Auth;
use Golem\Auth\Test\Example\User;

class AuthTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Auth
     */
    private $auth;

    /**
     * @var MemoryStorage
     */
    private $storage;

    /**
     * @var Repository
     */
    private $repository;

    public function setUp()
    {
        $this->storage = new MemoryStorage();
        $this->repository = new Repository();
        $this->auth = new Auth($this->storage, $this->repository);
    }

    public function test_logging_in_user()
    {
        $user = new User();
        $user->id = 1;
        $user->name = 'Bob';
        $user->email = 'bob@example.com';

        $this->assertFalse($this->auth->loggedIn());
        $this->auth->login($user);
        $this->assertTrue($this->auth->loggedIn());
        $this->assertEquals($user->id, $this->storage->read());
    }

    public function test_logging_out_user()
    {
        $user = new User();
        $user->id = 1;
        $user->name = 'Bob';
        $user->email = 'bob@example.com';

        $this->auth->login($user);
        $this->assertTrue($this->auth->loggedIn());
        $this->auth->logout();
        $this->assertFalse($this->auth->loggedIn());
        $this->assertFalse($this->storage->exists());
    }

    public function test_pulling_user_id()
    {
        $this->storage->store(1);
        $this->assertEquals(1, $this->auth->getUserId());
    }

    public function test_pulling_user_id_when_not_logged_in_returns_null()
    {
        $this->assertNull($this->auth->getUserId());
    }

    public function test_pulling_user_when_not_logged_in_returns_null()
    {
        $this->assertNull($this->auth->user());
    }

    public function test_loading_user_data()
    {
        // Force user id directly into storage
        $this->storage->store(1);
        $user = $this->auth->user();
        $this->assertInstanceOf('Golem\Auth\Test\Example\User', $user);
        $this->assertEquals(1, $user->getAuthId());
    }

    /**
     * @expectedException \RuntimeException
     */
    public function test_loading_invalid_user()
    {
        // Force user id directly into storage
        $this->storage->store(6);
        $user = $this->auth->user();
    }
}
