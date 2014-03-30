<?php

/**
 * AccountController.
 *
 * @author 8705
 */
class TaskController extends Controller
{
    //開発用に強制的にegamiユーザーでログイン
    // protected function dev_login($user) {
    //     $user = $this->db_manager->get('User')->fetchByUserName($user);
    //     $this->session->setAuthenticated(true);
    //     $this->session->set('user', $user);
    //     return $user;
    // }

    public function addAction() {
        if (!$this->request->isPost()) {
            $this->forward404();
        }
        //開発用ログイン
        // $user = $this->dev_login('egami');

        if(!$user) {
            $this->forward404();
        }

        $p_id       = $this->request->getPost('p_id');
        $project   = $this->db_manager->get('Project')->fetchProjectById($p_id);

        $t_title    = $this->request->getPost('t_title');
        $t_content  = $this->request->getPost('t_content');
        $t_size     = $this->request->getPost('t_size');

        if(!$project) {
            $this->forward404('そんなプロジェクトありません');
        }

        $errors = array();

        if(!strlen($t_title)) {
            $errors[] = 'タスク名を入力してね';
        }
        if(!$t_size) {
            $errors[] = 'タスクの大きさを選んでね';
        }

        if (count($errors) === 0) {
            // $user = $this->session->get('user');
            $this->db_manager->get('Task')->insert($p_id, $t_title, $t_content, $t_size);

            return $this->redirect('/');
        }
    }

    public function indexAction()
    {
        $user        = $this->session->get('user');
        $user = $this->db_manager->get('User')->fetchByUserName($user['username']);

        //開発用ログイン
        // $user = $this->dev_login('egami');

        if(!$user) {
            $this->forward404();
        }
        $tasks      = $this->db_manager->get('Task')->fetchAllTasksByUserId($user['id']);
        $projects   = $this->db_manager->get('Project')->fetchAllProjectsByUserId($user['id']);
        return $this->render(array(
            'user'       => $user,
            'tasks'   => $tasks,
            'projects'   => $projects
        ));
    }

    public function deleteAction($params){
        $task = $this->db_manager->get('Task')->fetchTaskById($params['property']);
        if(!$task || $task['del_flg'] === '1') {
            $this->forward404('そのタスクはないです');
        }

        $this->db_manager->get('Task')->delete($task['id']);

        return $this->redirect('/');

    }
}
