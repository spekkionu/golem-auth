<?php
namespace Golem\Auth\Test\Example;

use Golem\Auth\UserRepository;

class Repository implements UserRepository
{
    /**
     * @inheritDoc
     */
    public function findUserById($id)
    {
        if ($id != 1) {
            throw new \RuntimeException('User not found');
        }
        $user = new User();
        $user->id = $id;
        $user->name = 'Bob';
        $user->email = 'bob@example.com';

        return $user;
    }
}
