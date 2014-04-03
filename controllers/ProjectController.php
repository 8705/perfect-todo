<?php

/**
 * AccountController.
 *
 * @author 8705
 */
class ProjectController extends Controller
{
    //開発用に強制的にegamiユーザーでログイン
    // protected function dev_login($user) {
    //     $user = $this->db_manager->get('User')->fetchByUserName($user);
    //     $this->session->setAuthenticated(true);
    //     $this->session->set('user', $user);
    //     return $user;
    // }

    public function signupAction()
    {
        if ($this->session->isAuthenticated()) {
            return $this->redirect('/account');
        }

        return $this->render(array(
            'user_name' => '',
            'password'  => '',
            '_token'    => $this->generateCsrfToken('account/signup'),
        ));
    }


    public function addAction() {

        if (!$this->request->isPost()) {
            $this->forward404();
        }
        $user        = $this->session->get('user');
        //開発用ログイン
        // $user = $this->dev_login('egami');

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
            // $user = $this->session->get('user');
            $this->db_manager->get('Project')->insert($user['id'], $p_title, $p_content);

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
        $project = $this->db_manager->get('Project')->fetchProjectById($params['property']);
        if(!$project || $project['del_flg'] === '1') {
            $this->forward404('そのタスクはないです');
        }

        $this->db_manager->get('Project')->delete($project['id']);

        return $this->redirect('/');

    }
}
