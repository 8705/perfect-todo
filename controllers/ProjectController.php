<?php

/**
 * AccountController.
 *
 * @author 8705
 */
class ProjectController extends Controller
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
        $p_title    = $data['p_title'];
        $p_content  = $data['p_content'];

        $errors = array();

        if(!strlen($p_title)) {
            $errors[] = 'プロジェクト名を入力してね';
        }

        if (count($errors) === 0) {
            $this->db_manager->get('Project')->insert($user['id'], $p_title, $p_content);

            return $this->redirect('/');
        }
    }

    public function indexAction()
    {
        if (!$this->session->isAuthenticated()) return $this->redirect('/account/index');
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
        $project = $this->db_manager->get('Project')->fetchProjectById($params['property']);
        if(!$project || $project['del_flg'] === '1') {
            $this->forward404('そのタスクはないです');
        }

        $this->db_manager->get('Project')->delete($project['id']);

        return $this->redirect('/');

    }
}
