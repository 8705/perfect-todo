<?php

require_once dirname(__FILE__).'/../PerfectUnit.php';

class AccountControllerTest extends PerfectUnit
{

    public function setUp()
    {
        parent::setUp();
    }

    public function testIndex()
    {
        $this->get('/account/index');
        $this->text_is('#main div div div h2', 'ログイン');
    }

    public function testRegister()
    {
        $params = array('user_name' => 'ishino11',
                        'user_mail' => 'ishino11@gmail.com',
                        'user_password' => 'ishino11',
                        );
        $this->post('/account/register', $params);
        $this->header_is('status_code', 302);
        $this->header_is('Location', '/account/index');
    }

}