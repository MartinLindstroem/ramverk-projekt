<?php

namespace Marty\User;

use Anax\DatabaseActiveRecord\ActiveRecordModel;

/**
 * A database driven model.
 */
class User extends ActiveRecordModel
{
    /**
     * @var string $tableName name of the database table.
     */
    protected $tableName = "User";

    /**
     * Columns in the table.
     *
     * @var integer $user_id primary key auto incremented.
     */
    public $id;
    public $email;
    public $username;
    public $password;
    public $avatar;
    public $created;
    public $updated;
    public $deleted;
    public $active;

    /**
     * Set the password.
     *
     * @param string $password the password to use.
     *
     * @return void
     */
    public function setPassword($password)
    {
        $this->password = password_hash($password, PASSWORD_DEFAULT);
    }

    /**
     * Verify the username and the password, if successful the object contains
     * all details from the database row.
     *
     * @param string $username username to check.
     * @param string $password the password to use.
     *
     * @return boolean true if username and password matches, else false.
     */
    public function verifyPassword($username, $password)
    {
        $this->find("username", $username);
        return password_verify($password, $this->password);
    }
}