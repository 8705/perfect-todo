<?php

require_once dirname(__FILE__).'/../PerfectUnit.php';

class AccountControllerTest extends PerfectUnit
{

    public function setup()
    {
        parent::setup();
    }

    public function testIndex()
    {
        $this->get('/account/index');
        $this->text_is('#main div div div h2', 'ログイン');
    }

    public function testRegister()
    {
        $params = array('user_name'     => 'test',
                        'user_mail'     => 'test@test.com',
                        'user_password' => 'test',
                        );
        $this->post('/account/register', $params);
        $this->header_is('status_code', 200);
        //$this->login(3);
    }

}