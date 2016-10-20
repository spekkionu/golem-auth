<?php
namespace Golem\Auth\Storage;

interface StorageInterface
{
    /**
     * @param string|int $id
     * @return void
     */
    public function store($id);

    /**
     * @return string|int
     */
    public function read();

    /**
     * @return bool
     */
    public function exists();

    /**
     * Clears out identity
     */
    public function clear();
}
