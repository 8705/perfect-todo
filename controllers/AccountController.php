<?php

/**
 * AccountController.
 *
 * @author 8705
 */
class AccountController extends Controller
{
    protected $auth_actions = array('signout', 'follow');

    public function indexAction()
    {
        if ($this->session->isAuthenticated()) return $this->redirect('/task');

        return $this->render(array('_token' => $this->generateCsrfToken('account/index')));
    }

    public function signupAction()
    {
        if ($this->session->isAuthenticated())  return $this->redirect('/');
        if (!$this->request->isPost())          $this->forward404();

        $token = $this->request->getPost('_token');
        if (!$this->checkCsrfToken('account/index', $token)) return $this->redirect('/account/index');

        $postdata = array(
                          'username'   => $this->request->getPost('username'),
                          'mail'       => $this->request->getPost('mail'),
                          'password'   => $this->request->getPost('password'),
                          );

        $errors = $this->db_manager->get('User')->validateSignUp($postdata);

        if (count($errors) === 0)
        {
            $this->db_manager->get('User')->insert($postdata);
            $this->session->setAuthenticated(true);
            $user = $this->db_manager->get('User')->fetchByUserName($postdata['username']);
            $this->session->set('user', $user);

            return $this->redirect('/');
        }

        return $this->render(array(
            'username'  => $postdata['username'],
            'mail'      => $postdata['mail'],
            'password'  => $postdata['password'],
            'errors'    => $errors,
            '_token'    => $this->generateCsrfToken('account/index'),
        ), 'index');
    }

    public function signinAction()
    {
        if ($this->session->isAuthenticated()) return $this->redirect('/');
        if (!$this->request->isPost()) $this->forward404();

        $token = $this->request->getPost('_token');
        if (!$this->checkCsrfToken('account/index', $token)) return $this->redirect('/account/index');

        $postdata = array(
                          'username'   => $this->request->getPost('username'),
                          'password'   => $this->request->getPost('password'),
                          );

        $errors = $this->db_manager->get('User')->validateSignIn($postdata);

        if (count($errors) === 0)
        {
            $user_repository = $this->db_manager->get('User');
            $user = $user_repository->fetchByUserName($postdata['username']);

            if (!$user || ($user['password'] !== $user_repository->hashPassword($postdata['password'])))
            {
                $errors[] = 'ユーザIDかパスワードが不正です';
            } else {
                $this->session->setAuthenticated(true);
                $this->session->set('user', $user);

                return $this->redirect('/');
            }
        }

        return $this->render(array(
                             'username' => '',
                             'password'  => '',
                             '_token'    => $this->generateCsrfToken('account/signin'),
                            ));
    }

    public function signoutAction()
    {
        $this->session->clear();
        $this->session->setAuthenticated(false);

        return $this->redirect('/account/index');
    }

}
