<?php
namespace Golem\Auth\Test\Storage;

use PHPUnit\Framework\TestCase;
use Golem\Auth\Storage\NativeSession;

class NativeSessionTest extends TestCase
{
    /**
     * @var NativeSession
     */
    private $storage;

    public function setUp(): void
    {
        parent::setUp();
        if (isset($_SESSION['session_key'])) {
            unset($_SESSION['session_key']);
        }
        $this->storage = new NativeSession('session_key');
    }

    public function tearDown(): void
    {
        unset($_SESSION['session_key']);
        parent::tearDown();
    }

    public function test_storing_and_reading()
    {
        $this->storage->store(1);
        $this->assertEquals(1, $this->storage->read());
    }

    public function test_checking_if_data_exists()
    {
        $this->assertFalse($this->storage->exists());
        $this->storage->store(1);
        $this->assertTrue($this->storage->exists());
    }

    public function test_clearing_data()
    {
        $this->storage->store(1);
        $this->assertTrue($this->storage->exists());
        $this->storage->clear();
        $this->assertFalse($this->storage->exists());
    }

    public function test_reading_returns_null_when_there_is_no_data()
    {
        $this->assertNull($this->storage->read());
    }
}
