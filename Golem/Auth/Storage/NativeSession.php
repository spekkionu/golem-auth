<?php
namespace Golem\Auth\Storage;

class NativeSession implements StorageInterface
{
    /**
     * @var string
     */
    private $namespace;

    /**
     * NativeSession constructor.
     * @param string $namespace
     */
    public function __construct($namespace = 'golem_auth')
    {
        $this->namespace = $namespace;
    }

    /**
     * Stores identity
     * @param int|string $id
     */
    public function store($id)
    {
        $_SESSION[$this->namespace] = $id;
    }

    /**
     * Returns identity
     * @return int|string|null
     */
    public function read()
    {
        if (!$this->exists()) {
            return null;
        }
        return $_SESSION[$this->namespace];
    }

    /**
     * @return bool
     */
    public function exists()
    {
        return isset($_SESSION[$this->namespace]);
    }

    /**
     * Clears out identity
     */
    public function clear()
    {
        unset($_SESSION[$this->namespace]);
    }
}
