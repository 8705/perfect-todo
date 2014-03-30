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

        $post = $this->request->getPost();
        if (!$this->checkCsrfToken('account/index', $post['_token'])) return $this->redirect('/account/index');

        $post = array(
                          'username'   => $this->request->getPost('username'),
                          'mail'       => $this->request->getPost('mail'),
                          'password'   => $this->request->getPost('password'),
                          );

        $errors = $this->db_manager->get('User')->validateSignUp($post);

        if (count($errors) === 0)
        {
            $this->db_manager->get('User')->insert($post);
            $this->session->setAuthenticated(true);
            $user = $this->db_manager->get('User')->fetchByUserName($post['username']);
            $this->session->set('user', $user);

            return $this->redirect('/');
        }

        return $this->render(array(
            'username'  => $post['username'],
            'mail'      => $post['mail'],
            'password'  => $post['password'],
            'errors'    => $errors,
            '_token'    => $this->generateCsrfToken('account/index'),
        ), 'index');
    }

    public function signinAction()
    {
        if ($this->session->isAuthenticated()) return $this->redirect('/');
        if (!$this->request->isPost()) $this->forward404();

        $post = $this->request->getPost();
        var_dump($post);
        if (!$this->checkCsrfToken('account/index', $post['_token'])) return $this->redirect('/account/index');

        $errors = $this->db_manager->get('User')->validateSignIn($post);

        if (count($errors) === 0)
        {
            $user_repository = $this->db_manager->get('User');
            $user = $user_repository->fetchByUserName($post['username']);

            if (!$user || ($user['password'] !== $user_repository->hashPassword($post['password'])))
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
