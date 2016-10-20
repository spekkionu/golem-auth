# Golem Auth

[![Latest Stable Version](https://poser.pugx.org/golem/auth/v/stable.png)](https://packagist.org/packages/golem/auth)
[![Build Status](https://travis-ci.org/spekkionu/golem-auth.svg?branch=master)](https://travis-ci.org/spekkionu/golem-auth)
[![Code Coverage](https://scrutinizer-ci.com/g/spekkionu/golem-auth/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/spekkionu/golem-auth/?branch=master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/spekkionu/golem-auth/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/spekkionu/golem-auth/?branch=master)
[![Total Downloads](https://poser.pugx.org/golem/auth/downloads.png)](https://packagist.org/packages/golem/auth)

Simple authentication storage library.  

This library only handles the storage of authentication data. 
It does not handle the authentication itself or storage/retrieval of user data.

## Install

Via Composer

``` bash
$ composer require golem/auth
```

## Usage

You must have a user model that implements `Golem\Auth\Authenticatable`.

The `getAuthId` method must return a unique identifier for the user. 
This can be an auto-incrementing primary key, a uuid, a unique email address or username, or any other field that can be used to uniquely identify a user.

``` php
use Golem\Auth\Authenticatable;

class User implements Authenticatable
{
    public $id;
    public $name;
    public $email;
    
    public function getAuthId()
    {
        return $this->id;
    }
}
```

Your repository or database model must implement `Golem\Auth\UserRepository`.

The `findUserById` method must return the user object that implements `Golem\Auth\Authenticatable` for the given value of the field returned by `getAuthId`.

It should throw a RuntimeException if the user is not found.

``` php
class UserRepository implements \Golem\Auth\UserRepository
{
    public function findUserById($id)
    {
        // or whatever you need to do to pull a user record
        $data = $this->database->fetchRow('SELECT * from users WHERE id = ?', [$id]);
        if (!$data) {
            throw new \RuntimeException('User not found.');
        }
        return new User($data);
    }
}
```

You now can use the Golem Auth library.

``` php
// Use the native php session
session_start();
$storage = new \Golem\Auth\NativeSession();
// get an instance of your user repository however you need to
$userRepository = new UserRepository($database_connection);
$auth = new \Golem\Auth($storage, $userRepository);
```

### Logging in a User

You must pull a user record and check the credentials yourself.  This is not part of Golem Auth. 
I recommend using the [password_hash](http://us3.php.net/manual/en/function.password-hash.php), and [password_verify](http://us3.php.net/manual/en/function.password-verify.php) functions to check credentials.

``` php
// Should return a User instance that implements Golem\Auth\Authenticatable
$user = $userRepository->getByCredentials($email, $password);

// Store the user login
$auth->login($user);
```

### Checking for a logged in User

``` php
if ($auth->loggedIn()) {
  // The user is logged in
}

if (!$auth->loggedIn()) {
  // The user is not logged in
}

```

### Getting the user object for the currently logged in user

``` php
// The first time this is called a fresh user record will be pulled from the UserRepository.
// Any further calls will return the existing record.
// If there is no logged in user this will return null.
// If the logged in user cannot be pulled a RuntimeException will be thrown.
$user = $auth->user();

// Returns just the user identifier
// This does not pull anything from the UserRepository
$id = $auth->getUserId();
```

### Logging out the user

``` php
$auth->logout();
```

## Testing

``` bash
$ composer test
```

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
