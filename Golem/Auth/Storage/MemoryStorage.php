<?php
namespace Golem\Auth\Storage;

class MemoryStorage implements StorageInterface
{
    private $id;

    /**
     * @inheritDoc
     */
    public function store($id)
    {
        $this->id = $id;
    }

    /**
     * @inheritDoc
     */
    public function read()
    {
        return $this->id;
    }

    /**
     * @inheritDoc
     */
    public function exists()
    {
        return !is_null($this->id);
    }

    /**
     * @inheritDoc
     */
    public function clear()
    {
        $this->id = null;
    }
}
