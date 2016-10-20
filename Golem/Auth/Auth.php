<?php
namespace Golem\Auth;

use Golem\Auth\Storage\StorageInterface;

class Auth implements AuthInterface
{
    /**
     * @var StorageInterface
     */
    private $storage;

    /**
     * @var string|int|null
     */
    private $id;

    /**
     * @var Authenticatable|null
     */
    private $user;

    /**
     * @var UserRepository
     */
    private $repository;

    /**
     * Auth constructor.
     * @param StorageInterface $storage
     * @param UserRepository $repository
     */
    public function __construct(StorageInterface $storage, UserRepository $repository)
    {
        $this->storage = $storage;
        $this->repository = $repository;
    }

    /**
     * @return bool
     */
    public function loggedIn()
    {
        if ($this->id === null) {
            $this->id = -1;
            if ($this->storage->exists()) {
                $this->id = $this->storage->read();
            }
        }
        return $this->id != -1;
    }

    /**
     * @return Authenticatable|null
     * @throws \RuntimeException
     */
    public function user()
    {
        if ($this->user === null && $this->loggedIn()) {
            $this->user = $this->repository->findUserById($this->id);
        }
        return $this->user;
    }

    /**
     * @return int|string|null
     */
    public function getUserId()
    {
        if (!$this->loggedIn()) {
            return null;
        }
        return $this->id;
    }

    /**
     * @param Authenticatable $user
     */
    public function login(Authenticatable $user)
    {
        $this->storage->store($user->getAuthId());
        $this->user = $user;
        $this->id = $user->getAuthId();
    }

    /**
     * Logs out user
     */
    public function logout()
    {
        $this->storage->clear();
        $this->user = null;
        $this->id = -1;
    }
}
