<?php

/**
 * UserRepository.
 *
 * @author 8705
 */
class UserRepository extends DbRepository
{
    public function insert($post)
    {
        $post['password'] = $this->hashPassword($post['password']);
        $now = new DateTime();

        $sql = "INSERT INTO users (
                    username,
                    mail,
                    password,
                    created,
                    modified
                )
                VALUES
                (
                    ?,
                    ?,
                    ?,
                    ?,
                    ?
                )";

        $stmt = $this->execute(
                    $sql,
                    array($post['username'],
                          $post['mail'],
                          $post['password'],
                          $now->format('Y-m-d H:i:s'),
                          $now->format('Y-m-d H:i:s'))
                );
    }

    public function validateSignUp($post)
    {
        $errors = array();

        if (!strlen($post['username'])) {
            $errors[] = 'ユーザIDを入力してください';
        } else if (!preg_match('/^\w{3,20}$/', $post['username'])) {
            $errors[] = 'ユーザIDは半角英数字およびアンダースコアを3 ～ 20 文字以内で入力してください';
        } else if (!$this->isUniqueUserName($post['username'])) {
            $errors[] = 'ユーザIDは既に使用されています';
        }

        if (!strlen($post['password'])) {
            $errors[] = 'パスワードを入力してください';
        } else if (!(4 <= strlen($post['password']) and strlen($post['password']) <= 30)) {
            $errors[] = 'パスワードは4 ～ 30 文字以内で入力してください';
        }

        return $errors;
    }

    public function validateSignIn($post)
    {
        $errors = array();

        if (!strlen($post['username']))
        {
            $errors[] = 'ユーザIDを入力してください';
        }

        if (!strlen($post['password']))
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
        $sql = "SELECT * FROM users WHERE username = ?";

        return $this->fetch($sql, array($username));
    }

    public function isUniqueUserName($username)
    {
        $sql = "SELECT COUNT(id) as count FROM users WHERE username = ?";

        $row = $this->fetch($sql, array($username));
        if ($row['count'] === '0') {
            return true;
        }

        return false;
    }

}
