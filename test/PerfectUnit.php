<?php

require_once dirname(__FILE__).'/../PerfectApplication_dev.php';

class PerfectUnit extends PHPUnit_Framework_TestCase
{
    protected $app;

    public function setUp()
    {
        $this->app = new PerfectApplication_dev(true);
    }

    public function dispatch($path)
    {
        return $this->app->run($path);
    }

    public function post($path, $params)
    {
        $_SERVER['REQUEST_METHOD'] = 'POST';
        $_SERVER['SERVER_NAME'] = 'Test';
        $_POST = $params;
        return $this->app->run($path);
    }

}