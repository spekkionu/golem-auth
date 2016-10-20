<?php
namespace Golem\Auth;

interface AuthInterface
{
    /**
     * Determine if the current user is logged in.
     *
     * @return bool
     */
    public function loggedIn();

    /**
     * Get the currently authenticated user.
     *
     * @return Authenticatable|null
     */
    public function user();

    /**
     * Get the unique identifier for the currently logged in user.
     *
     * @return int|string|null
     */
    public function getUserId();

    /**
     * Set the current user.
     *
     * @param  Authenticatable  $user
     * @return void
     */
    public function login(Authenticatable $user);

    /**
     * Logs user out
     *
     * @return void
     */
    public function logout();
}
