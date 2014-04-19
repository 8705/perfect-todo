<?php

require_once dirname(__FILE__).'/../PerfectApplication_dev.php';

class PerfectUnit extends PHPUnit_Framework_TestCase
{
    public $app;

    public function setUp()
    {
        $this->app = new PerfectApplication_dev(true);
    }
    public function dispatch($path) {

        return $this->app->run($path);
    }

    // public function testIndex()
    // {
    //     $content = $this->app->run('/account/index');
    // }
}