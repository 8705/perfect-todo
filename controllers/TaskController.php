<?php

/**
 * AccountController.
 *
 * @author 8705
 */
class TaskController extends Controller
{
    protected $auth_actions = array('index', 'add', 'delete');

    public function addAction() {
        if (!$this->request->isPost()) {
            $this->forward404();
        }
        $user        = $this->session->get('user');
        if(!$user) {
            $this->forward404();
        }

        $data       = $this->request->getPost();
        $p_id       = $data['p_id'];
        $project    = $this->db_manager->get('Project')->fetchProjectById($p_id);

        $t_title    = $data['t_title'];
        $t_content  = $data['t_content'];
        $t_size     = $data['t_size'];

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
            $this->db_manager->get('Task')->insert($p_id, $t_title, $t_content, $t_size);

            return $this->redirect('/');
        }
    }

    public function indexAction()
    {
        $user        = $this->session->get('user');
        $user = $this->db_manager->get('User')->fetchByUserName($user['username']);

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
