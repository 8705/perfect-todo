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
        $content = $this->dispatch('/account/index');
        $this->assertContains('アカウント - Perfect Todo', $content);
    }

    public function testRegister()
    {
        $params = array('user_name' => 'ishino11',
                        'user_mail' => 'ishino11@gmail.com',
                        'user_password' => 'ishino11',
                        '_token' => 'test_token',
                        );
        $content = $this->post('/account/register', $params);

        debug(headers_list());
        $this->assertContains('タスクリスト', $content);
    }
}