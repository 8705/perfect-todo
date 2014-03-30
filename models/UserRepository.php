<?php

/**
 * UserRepository.
 *
 * @author 8705
 */
class UserRepository extends DbRepository
{
    public function insert($postdata)
    {
        $postdata['password'] = $this->hashPassword($postdata['password']);
        $now = new DateTime();

        $sql = "INSERT INTO users (
                                   username,
                                   mail,
                                   password,
                                   created,
                                   modified
                                   ) VALUES (
                                   :username,
                                   :mail,
                                   :password,
                                   :created,
                                   :modified
                                   )";

        $stmt = $this->execute($sql, array(
            ':username' => $postdata['username'],
            ':mail'     => $postdata['mail'],
            ':password' => $postdata['password'],
            ':created'  => $now->format('Y-m-d H:i:s'),
            ':modified' => $now->format('Y-m-d H:i:s'),
        ));
    }

    public function validateSignUp($postdata)
    {
        $errors = array();

        if (!strlen($postdata['username'])) {
            $errors[] = 'ユーザIDを入力してください';
        }
        //  else if (!preg_match('/^\w{3,20}$/', $postdata['username'])) {
        //     $errors[] = 'ユーザIDは半角英数字およびアンダースコアを3 ～ 20 文字以内で入力してください';
        // } else if (!$this->db_manager->get('User')->isUniqueUserName($postdata['username'])) {
        //     $errors[] = 'ユーザIDは既に使用されています';
        // }

        if (!strlen($postdata['password'])) {
            $errors[] = 'パスワードを入力してください';
        } else if (!(4 <= strlen($postdata['password']) and strlen($postdata['password']) <= 30)) {
            $errors[] = 'パスワードは4 ～ 30 文字以内で入力してください';
        }

        return $errors;
    }

    public function validateSignIn($postdata)
    {
        $errors = array();

        if (!strlen($postdata['username']))
        {
            $errors[] = 'ユーザIDを入力してください';
        }

        if (!strlen($postdata['password']))
        {
            $errors[] = 'パスワードを入力してください';
        }

        return $errors;
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
        $sql = "SELECT COUNT(id) as count FROM users WHERE username = :username";

        $row = $this->fetch($sql, array(':username' => $username));
        if ($row['count'] === '0') {
            return true;
        }

        return false;
    }

}
