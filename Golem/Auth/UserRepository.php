<?php
namespace Golem\Auth;

interface UserRepository
{
    /**
     * @param int|string $id
     * @return Authenticatable
     * @throws \RuntimeException
     */
    public function findUserById($id);
}
