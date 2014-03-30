<?php

/**
 * UserRepository.
 *
 * @author 8705
 */
class UserRepository extends DbRepository
{
    public function insert($username, $password)
    {
        $password = $this->hashPassword($password);
        $now = new DateTime();

        $sql = "
            INSERT INTO user(username, password, created_at)
                VALUES(:username, :password, :created_at)
        ";

        $stmt = $this->execute($sql, array(
            ':username'  => $username,
            ':password'   => $password,
            ':created_at' => $now->format('Y-m-d H:i:s'),
        ));
    }

    public function hashPassword($password)
    {
        return sha1($password . 'SecretKey');
    }

    public function fetchByUserName($username)
    {
        $sql = "SELECT * FROM users WHERE username = :username";

        return $this->fetch($sql, array(':username' => $username));
    }

    public function isUniqueUserName($username)
    {
        $sql = "SELECT COUNT(id) as count FROM user WHERE username = :username";

        $row = $this->fetch($sql, array(':username' => $username));
        if ($row['count'] === '0') {
            return true;
        }

        return false;
    }

    public function fetchAllFollowingsByUserId($user_id)
    {
        $sql = "
            SELECT u.*
                FROM user u
                    LEFT JOIN following f ON f.following_id = u.id
                WHERE f.user_id = :user_id
        ";

        return $this->fetchAll($sql, array(':user_id' => $user_id));
    }
}
