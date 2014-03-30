<?php

/**
 * UserRepository.
 *
 * @author 8705
 */
class ProjectRepository extends DbRepository
{
    public function insert($user_id, $p_title, $p_content)
    {
        $now = new DateTime();

        $sql = "
            INSERT INTO projects(user_id, p_title, p_content, created)
                VALUES(:user_id, :p_title, :p_content,:created)
        ";

        $stmt = $this->execute($sql, array(
            ':user_id'  => $user_id,
            ':p_title'   => $p_title,
            ':p_content'   => $p_content,
            ':created' => $now->format('Y-m-d H:i:s'),
        ));
    }

    public function fetchAllProjectsByUserId($user_id) {
        $sql = "
            SELECT p.*, u.username
                FROM projects p
                    LEFT JOIN users u ON p.user_id = u.id
                WHERE u.id = :user_id
                    AND p.del_flg = '0'
                ORDER BY p.created DESC
        ";

        return $this->fetchAll($sql, array(':user_id' => $user_id));
    }


    public function fetchProjectById($project_id)
    {
        $sql = "SELECT * FROM projects WHERE id = :project_id";

        return $this->fetch($sql, array(':project_id' => $project_id));
    }

    public function delete($project_id) {
        $now = new DateTime();
        $sql = "
            UPDATE projects SET
                del_flg = '1',
                modified = ?
                    WHERE id = ?
            ";

        $stmt = $this->execute($sql, array(
            $now->format('Y-m-d H:i:s'),
            $project_id,
        ));
    }
}
