<?php

namespace Application\Utility\Authentication;

use JasperFW\Authentication\Type\DatabaseUser;
use JasperFW\DataAccess\DAO;

class CMUser extends DatabaseUser
{
    protected static $authenticationTable = 'users';
    protected static $userIDColumn = 'user_id';
    protected static $usernameColumn = 'username';
    protected static $passwordColumn = 'password';
    protected static $emailColumn = 'email';
    protected static $expirationColumn = 'expiration';
    protected static $resetTokenColumn = 'reset_token';
    protected static $resetTokenExpirationColumn = 'reset_token_expiration';

    protected $userType = 'guest';

    /**
     * Get the type of user from the database. This could be replaced with a check for roles, or anything else about the
     * user that should be stored as part of the user object.
     *
     * @param DAO $dbc
     */
    public function populateUserInfo(DAO $dbc): void
    {
        $query = 'SELECT user_type FROM users WHERE user_id = :userid';
        $result = $dbc->getStatement($query)->execute([':userid' => $this->getUserID()])->toArray();
        if (count($result) > 0) {
            $this->userType = $result[0]['user_type'];
        }
    }

    public function getUserType(): string
    {
        return $this->userType;
    }
}