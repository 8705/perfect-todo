<?php

require_once dirname(__FILE__).'/../PerfectUnit.php';

class AccountControllerTest extends PerfectUnit
{

    function setUp()
    {
        parent::setUp();
    }

    /**
     *
     * @test
     */
    function index()
    {
        $this->get('/account/index');
        $this->text_is('#main div div div h2', 'ログイン');
    }

    /**
     *
     * @test
     */
    function register()
    {
        $params = array('user_name'     => 'test2',
                        'user_mail'     => 'test2@test.com',
                        'user_password' => 'test',
                        );
        /**
         *
         * @test
         */
        function aaaa()
        {
            $this->post('/account/register', $params);
            $this->header_is('status_code', 302);
        }

    }

}