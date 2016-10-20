<?php
namespace Golem\Auth\Test\Example;

use Golem\Auth\Authenticatable;

class User implements Authenticatable
{
    public $id;
    public $name;
    public $email;

    /**
     * @inheritDoc
     */
    public function getAuthId()
    {
        return $this->id;
    }
}
