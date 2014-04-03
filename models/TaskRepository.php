<?php

/**
 * UserRepository.
 *
 * @author 8705
 */
class TaskRepository extends DbRepository
{
    public function fetchAllTasksByUserId($user_id) {
        $sql = "SELECT t.*,
                       p.id as p_id,
                       p.p_title as p_title,
                       u.id as u_id,
                       u.username as username
                    FROM tasks t
                        LEFT JOIN projects p ON p.id = t.project_id
                        LEFT JOIN users u ON p.user_id = u.id
                    WHERE p.user_id = :user_id and t.del_flg = '0'
                    ORDER BY t.created DESC";

        return $this->fetchAll($sql, array(':user_id' => $user_id));
    }

    public function insert($project_id, $t_title, $t_content, $t_size)
    {
        $now = new DateTime();

        $sql = "INSERT INTO tasks (project_id, t_title, t_content, t_size, created, modified)
                VALUES(?,?,?,?,?,?)";

        $stmt = $this->execute($sql, array(
            $project_id,
            $t_title,
            $t_content,
            $t_size,
            $now->format('Y-m-d H:i:s'),
            $now->format('Y-m-d H:i:s'),
        ));
    }


    public function fetchTaskById($task_id)
    {
        $sql = "SELECT * FROM tasks WHERE id = :task_id";

        return $this->fetch($sql, array(':task_id' => $task_id));
    }

    public function delete($task_id) {
        $now = new DateTime();
        $sql = "UPDATE tasks SET del_flg = '1', modified = ? WHERE id = ?";

        $stmt = $this->execute($sql, array(
            $now->format('Y-m-d H:i:s'),
            $task_id,
        ));
    }
}
