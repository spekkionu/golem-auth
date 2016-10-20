<?php
namespace Golem\Auth;

interface Authenticatable
{
    /**
     * @return string|int
     */
    public function getAuthId();
}
