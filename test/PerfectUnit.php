<?php

require_once dirname(__FILE__).'/../PerfectApplication_dev.php';

class PerfectUnit extends PHPUnit_Framework_TestCase
{
    protected $app;
    protected $db_manager;
    protected $session;
    protected $token;
    protected $header_info;
    
    public function setup()
    {
        $this->app        = new PerfectApplication_dev(true);
        $this->db_manager = $this->app->getDbManager();
        $this->session    = $this->app->getSession();
        $this->token      = 'q3p98fpeifhqpwef348pqc3yhpw348rcp3rvwe8pqytppweytp';
        $_SESSION['csrf_tokens/_token'] = array($this->token);
        $_SERVER['SERVER_NAME'] = 'TestHost';
    }

    public function get($path)
    {
        $_SERVER['REQUEST_METHOD'] = 'GET';

        $this->header_info = $this->app->run($path);
    }

    public function post($path, $params)
    {
        $_SERVER['REQUEST_METHOD'] = 'POST';
        $params['_token'] = $this->token;
        $_POST = $params;

        $this->header_info = $this->app->run($path);
    }

    public function header_is($type, $param)
    {
        if ($type == 'Location') {
            $protocol = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') ? 'https://' : 'http://';
            $host     = $_SERVER['SERVER_NAME'];
            $base_url = $_SERVER['REQUEST_URI'];
            $param    = $protocol.$host.$base_url.$param;
        }

        $this->assertEquals($this->header_info[$type], $param);
    }

    public function text_is($selector, $text)
    {
        $this->xml = new DomDocument;
        $this->xml->loadXML($this->header_info['content']);

        $this->assertSelectEquals($selector, $text, true, $this->xml);
    }

    public function login($user_id)
    {
        $user = $this->db_manager->get('User')->fetchById($user_id);
        if ($user) {
            $this->session->setAuthenticated(true);
            $this->session->set('user', $user);
        } else {
            echo 'そのUserIdはDBに登録されていません。';
            exit;
        }
    }

}