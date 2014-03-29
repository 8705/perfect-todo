<?php

/**
 * PerfectApplication.
 *
 * @author 8705
 */
class PerfectApplication extends Application
{
    protected $login_action = array('account', 'signin');

    public function getRootDir()
    {
        return dirname(__FILE__);
    }

    protected function registerRoutes()
    {
        return array(
            '/'
                => array('controller' => 'task', 'action' => 'index'),
            '/:controller/'
                => array('action' => 'index'),
            '/:controller/:action'
                => array(),
            '/:controller/:action/:property'
                => array(),
            '/:controller/:action/:property/:property2'
                => array(),
        );
    }

    protected function configure()
    {
        $this->db_manager->connect('master', array(
            'dsn'      => 'mysql:dbname=mini_blog;host=localhost',
            'user'     => 'root',
            'password' => '',
        ));
    }
}
